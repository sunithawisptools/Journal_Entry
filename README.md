#  JournalEntry creation

## Requirements

In order to successfully run this sample app you need a few things:

1. Latest version of PHP on your machine. This sample uses PHP 5.6.3.
2. Install Apache Server and configure PHP 5 to run with Apache Server
3. Download Intuit’s latest PHP devkit from GitHub https://developer.intuit.com/docs/0100_quickbooks_online/0400_tools/0005_accounting/0209_php. This sample uses v3-php-sdk-2.2.0-RC. (v3-php-sdk-2.2.0-RC is also included in this repository for your convenience!) 
5. For Oauth implementation, this sample uses the Pecl Oauth library. Please download the Oauth 
package from this [page](http://pecl.php.net/package/oauth)
6. A [developer.intuit.com](http://developer.intuit.com) account
7. An app on [developer.intuit.com](http://developer.intuit.com) and the associated app token, consumer key, and consumer secret.

## Create App

1. Create an account in (https://developer.intuit.com/).
2. To create the app click on My Apps link in the top menu.
3. Click on the "select API" button.And select both payment API and account API, and click on the "create app" button.
4. Now the app is created and you will get the keys (App token,OAuth consumer key and OAuth consumer secret key).These oauth keys are used in the config file during the journal creation.


## First Use Instructions

1. Clone the GitHub repo to your computer
2. Place our PHPOAuthSample folder and the downloaded v3-php-sdk-2.2.0-RC folder inside the web folder of the Apache web server.
3. This sample is using the sandbox environment by default. So, you need to use the development tokens of your app for running this sample. If you want to switch to production, please make sure that you change the baseUrl in app.config file inside PHPOAuthSample folder to quickbooks.api.intuit.com from sandbox-quickbooks.api.intuit.com. Also, make sure that you configure the sample app to use prod tokens instead of development tokens.
4. **Configuring the app tokens**: Go to your app on developer.intuit.com and copy the OAuth Consumer Key and OAuth Consumer Token from the keys tab. Add these values to the **config.php** file in our PHPOAuthSample folder and in the **app.config** file inside the oauth-php-master.
5. Define the base_url in the config file.Because this url is used in the index file.(define('BASE_URL', 'http://example.com/oauth-php-master'))



## Running the code

Once the sample app code is on your computer, you can do the following steps to run the app:

1. Index.php is the starting page for our sample. Open the index.php file in the web browser.
2. Connect your app to Quickbooks, by clicking on “Connect to QuickBooks” button and follow the steps.
3. After successfully connecting the app to QuickBooks, you will see the realmID, Oauth token and Oauth secret on the webpage.At the same time, it will create a file newfile.php with this realmID, Oauth token and Oauth secret.This data is used by fetching it into **app.config** file inside the oauth-php-master.


### High Level Workflow

1. Connect to a QuickBooks Online company by clicking on **Connect to QuickBooks** button.
2. The app.config file will fetch the realmID, Oauth token and Oauth secret from the newfile.php(created when you connect the app to quickbooks)


### journal creation

1. The create_journal file has the code to create the journal entry.This file is loaded when you set this create_journal url in the "createQuickbookEntry" function in the search controller of customer_portal($url=http://example.com/oauth-php-master/createJournal.php)

Get login into (https://sandbox-quickbooks.api.intuit.com/)...Select the company to which you connected your app.Then search 'jornal entry' in the search box. The you can see the jounal entries that you have created.



