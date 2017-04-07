<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <script type="text/javascript" src="https://appcenter.intuit.com/Content/IA/intuit.ipp.anywhere.js"></script>
    </head>
    <body>
        <?php
        $myfile = fopen("Authentication/oauth_data.json", "r") or die("Unable to open file!");
        $gcontent = fread($myfile, filesize("Authentication/oauth_data.json"));
        $expc = json_decode($gcontent);
        $sum = $_POST['amt'];
        $date = $_POST['date'];
        require_once('v3-php-sdk-2.2.0-RC/config.php');
        require_once(PATH_SDK_ROOT . 'Core/ServiceContext.php');
        require_once(PATH_SDK_ROOT . 'DataService/DataService.php');
        require_once(PATH_SDK_ROOT . 'PlatformService/PlatformService.php');
        require_once(PATH_SDK_ROOT . 'Utility/Configuration/ConfigurationManager.php');
        require_once(PATH_SDK_ROOT . 'Core/OperationControlList.php');
//Specify QBO or QBD
        $serviceType = IntuitServicesType::QBO;
// Get App Config
        $realmId = $expc->realmId;
        if (!$realmId)
            exit("Please add realm to App.Config before running this sample.\n");
// Prep Service Context

        $requestValidator = new OAuthRequestValidator($expc->oauth_token, $expc->oauth_token_secret, ConfigurationManager::AppSettings('ConsumerKey'), ConfigurationManager::AppSettings('ConsumerSecret'));

        $serviceContext = new ServiceContext($realmId, $serviceType, $requestValidator);
        if (!$serviceContext)
            exit("Problem while initializing ServiceContext.\n");
// Prep Data Services
        $dataService = new DataService($serviceContext);
        if (!$dataService)
            exit("Problem while initializing DataService.\n");
        $linedet = new IPPJournalEntryLineDetail();
        $linedet->PostingType = 'Debit';
        $linedet->AccountRef = 1;
        $line = new IPPLine();
        $line->Id = 0;
        $line->Description = 'Journal entry for ' . $date;
        $line->Amount = $sum;
        $line->DetailType = 'JournalEntryLineDetail ';
        $line->JournalEntryLineDetail = $linedet;
        $linedet2 = new IPPJournalEntryLineDetail();
        $linedet2->PostingType = 'Credit';
        $linedet2->AccountRef = 1;
        $line2 = new IPPLine();
        $line2->Id = 1;
        $line2->Description = 'Journal entry for ' . $date;
        $line2->Amount = $sum;
        $line2->DetailType = 'JournalEntryLineDetail ';
        $line2->JournalEntryLineDetail = $linedet2;
// Add a journal
        $journalObj = new IPPJournalEntry();
        $journalObj->Line = array($line, $line2);
        $resultingjournalObj = $dataService->Add($journalObj);
//print_r($resultingjournalObj);
        echo "<br />Created Journal Id={$resultingjournalObj->Id}. <br /> <br />  Reconstructed response body:<br />";
        $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($resultingjournalObj, $urlResource);
        echo $xmlBody . "\n";
        ?>

    </script>
</body>
</html>
