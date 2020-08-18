# magento_test_task3

A client wants to change the color of their buttons on a daily basis to attract more customers
and to find the perfect one for their store. They do not want to create a ticket on a daily basis, so their IT technicians should be able to change everything without any Magento knowledge.
You need to create a Magento console command, which will have HEX color and a Store View
IDs as parameters. And change the color of all buttons on that Store view into the color
provided.
Example of usage
./bin/magneto scandiweb:color-change 000000 1

After running this command in DEV mode all the buttons on the store view with id 1 should be
black.
It is also a good idea to check if the client’s IT guys will not type a non-existing store or wrong format color.
You can use any Magento 2 installation that you have as long as there are multiple stores set
up on it.
Please also attach the documented installation process an

------------
Module Installation 
------------

### 1. Using Zip File

* Download the Extension Zip File
* Extract & upload the files to /path/to/magento2/app/code/Baracat/Task2/

After installation by either means, enable the extension by running following commands (from root of Magento2 installation):

Then you should run Magento's setup upgrade:
```
php bin/magento setup:upgrade
```
Lastly clear Magento generated suff and caches:
```
rm -rf pub/static/frontend/
rm -rf var/view_preprocessed/css/frontend/
php bin/magento cache:clean
```
------------
Solution
------------
A new module was created to meet the customer's needs.

Module features:

### 1. I created buttons color admin option using system.xml

![alt text](https://raw.githubusercontent.com/baracatuemura/magento_test_task2/master/_info/image1.png)


### 2. Console command.

Console command was created to validate, save the buttons color field and clear the cache after recording.

**code and files:**

![alt text](https://raw.githubusercontent.com/baracatuemura/magento_test_task2/master/_info/image7.png)

**command line:**
```
php bin/magento scandiweb:color-change --color="ff00ff" --store="1"
```

![alt text](https://raw.githubusercontent.com/baracatuemura/magento_test_task2/master/_info/image2.png)

### 3. Block class and template 

I created this Block class and template to get the saved color information and render the new buttons CSS

![alt text](https://raw.githubusercontent.com/baracatuemura/magento_test_task2/master/_info/image8.png)

I used the XML layout file to include these new block with CSS in the store header.

![alt text](https://raw.githubusercontent.com/baracatuemura/magento_test_task2/master/_info/image9.png)


------------
Result
------------

------------
Console command validation Screenshot.
------------

Invalid color
![alt text](https://raw.githubusercontent.com/baracatuemura/magento_test_task2/master/_info/image5.png)

Invalid ID
![alt text](https://raw.githubusercontent.com/baracatuemura/magento_test_task2/master/_info/image6.png)

------------
Screenshot of final result
------------
![alt text](https://raw.githubusercontent.com/baracatuemura/magento_test_task2/master/_info/image4.png)

------------
Test
------------
To change buttons color use this console command below:

```
php bin/magento scandiweb:color-change --color="ff00ff" --store="1"
```