<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Baracat\Task2\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Scandiweb extends Command
{

    const COLOR = 'color';
    const STORE = 'store';
    const XML_PATH_COLOR = 'buttons_color/buttons_color/btn_color';

    private $scopeConfig;
    private $cacheManager;

    /**
     *  @var \Magento\Framework\App\Config\Storage\WriterInterface
     */
    protected $configWriter;
    protected $repository;
    
    public function __construct(
       ScopeConfigInterface $scopeConfig,
       \Magento\Framework\App\Config\Storage\WriterInterface $configWriter,
       \Magento\Store\Api\StoreRepositoryInterface $repository ,
    \Magento\Framework\App\Cache\Manager $cacheManager

    ){
        $this->scopeConfig = $scopeConfig;
        $this->configWriter = $configWriter;
        $this->cacheManager = $cacheManager;
        $this->repository = $repository;

        parent::__construct();
    }

    protected function configure()
    {

        $options = [
            new InputOption(
                self::COLOR,
                null,
                InputOption::VALUE_REQUIRED,
                'color'
            ),
            new InputOption(
                self::STORE,
                null,
                InputOption::VALUE_REQUIRED,
                'store'
            )
        ];

        $this->setName('scandiweb:color-change')
            ->setDescription('Demo command line')
            ->setDefinition($options);

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $changed=false;
        if ($storeId = $input->getOption(self::STORE)) {
            /** @var \Magento\Store\Api\StoreRepositoryInterface $repository */
            $stores = $this->repository->getList();
            foreach ($stores as $store) {
                if($store->getId() == $storeId){

                    if ($newColor = $input->getOption(self::COLOR)) {
                        $storeName = $store->getName();
                        if (preg_match('/^#?(([a-f0-9]{3}){1,2})$/i', $newColor)) {
                            $output->writeln("seting up $newColor for store view: $storeName ($storeId)");
                            $this->configWriter->save(self::XML_PATH_COLOR,  $newColor, $scope = 'stores', $storeId);
                            $output->writeln("flush config and layout cache");
                            $this->cacheManager->flush(['config','layout']);
                            // or this
                            //$this->cacheManager->clean($this->cacheManager->getAvailableTypes());
                            $changed=true;
                        } else {
                            $output->writeln("$newColor does not consist of all hexadecimal color.\n");
                        }
                    } 
                    break;
                }
            }
        }

        if(!$changed){
            $output->writeln("Invalid store ID");
        }else {
            $color =  $this->scopeConfig->getValue(self::XML_PATH_COLOR, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $storeId);
            $output->writeln("New color buttons is $color for store view: $storeName ($storeId)");
            $changed=false;
        }

        return $this;

    }
}
