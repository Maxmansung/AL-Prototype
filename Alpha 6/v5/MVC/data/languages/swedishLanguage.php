<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
include_once ($_SERVER['DOCUMENT_ROOT']."/MVC/data/languages/languageInterface.php");
class swedishLanguage implements languageInterface
{
    function getFlag()
    {
        return "Sweden.png";
    }




    //THIS IS FOR THE TITLE PAGE PRIOR TO LOGGING INTO THE GAME

    //The first writing seen on the front page of the site
    function loginMasterPageTitle(){
        return "Livet efter döden är fantastiskt …";
    }

    //Explanation text following the title on the front page
    function loginMasterPageWriting(){
        return "Du vaknar upp i snön, osäker på vart du är och vad som omger dig. Allt du vet är att du en gång levde, men nu känner du dig allt annat än vid liv. Det verkar som att de hade rätt om att det finns ett liv efter döden; olyckligtvis så består den av en oändlig cykel av död och uppvaknande i ett kargt ödeland.
            <br><br>
	    Kan du lyckas vinna över gudarna i denna undervärld och finna frid?";
    }

    //This is the button suggesting to play (All in capitals)
    function loginMasterPagePlayNow(){
        return "SPELA NU";
    }

    //This is the button to sign up to the game
    function loginMasterPageSignupFree()
    {
        return "REGISTRERA DIG GRATIS";
    }

    //This is the title to the text describing the page
    function loginMasterPageAboutTitle()
    {
        return "About the game";
    }

    //These discuss different ways to play the game. Var 1 is the title and the rest is the description
    //Description 1 look at solo play
    function loginMasterPageDescription1($var)
    {
        if($var === 1){
            return "By yourself...";
        }
        else {
            return "Become a lone wolf, roaming the wasteland without a care for anyone. Save your own skin whilst those around you freeze to death. Its a harsh world but there are gods that favour only the strong.";
        }
    }

    //Description 2 look s at group play
    function loginMasterPageDescription2($var)
    {
        if($var === 1){
            return "In a team...";
        }
        else {
            return "Find others and team up to survive, create a camp and build up your defenses, then laugh from your walls as others around you freeze in the snow. Gain the favour of the gods of clans as you fight to be the last survivors.";
        }
    }

    //Description 3 looks at trying to unite and entire map
    function loginMasterPageDescription3($var)
    {
        if($var === 1){
            return "Unite the world...";
        }
        else {
            return "Communicate with the rest of the map and work to unite the world. Perhaps together you can overcome this cycle and find peace?<br><br>Do you trust those around you enough to open your gates and let in the masses though...";
        }
    }

    //Description 4 about trying to tear the world apart
    function loginMasterPageDescription4($var)
    {
        if($var === 1){
            return "Tear it apart...";
        }
        else {
            return "Destroy the land around you as you scrape every last resource out of it. Dig, explode and even summon the will of the gods until all that remains is the cold hard stone below your feet";
        }
    }

    //This suggests to people about playing the game on their phone or tabled too
    function loginMasterPageOnPhone($var)
    {
        if($var === 1){
            return "På din mobil eller platta!";
        }
        else {
            return "Graeco pericula torquatos pri cu! Tollit urbanitas sadipscing id eos, id est melius labitur corrumpit, an quaeque dolores electram nec? Vix te quas ignota, wisi labore ex vis! Quo eu euismod incorrupte! Sed ei legendos partiendo imperdiet.

                Cu vidit epicuri gloriatur vel, te erant facete sed! Ut pro eros alterum aliquid, omittam delicata urbanitas eos ex, pro veri velit sadipscing ne! Consul persecuti at sea, novum abhorreant pro in. Dico unum ignota ius an, ius adhuc tractatos an, ei mel duis iudico oporteat. Cu velit temporibus sed, aliquid nonumes vel ei.

                Dico nullam consulatu eam te? Ne eos verear nostrum.";
        }
    }






    //THIS IS FOR THE TITLE BANNER OF THE LOGIN PAGE

    //This is the login button on the banner
    function loginNavLogin()
    {
        return "Logga in";
    }

    //This is the sign up button on the banner (In capitals)
    function loginNavSignup()
    {
        return "REGISTRERA";
    }

    //One of the nav bar links, links to playing the game
    function loginNavPlay()
    {
        return "Spela";
    }

    //Nav bar link to the wiki with further details about the game
    function loginNavWiki()
    {
        return "Hjälp";
    }

    //Nav bar link to the blog page that will give further details about game development of the game
    function loginNavBlog()
    {
        return "Blogg";
    }

    //Nav bar link that allows you to change your language
    function loginNavLanguage()
    {
        return "Språk";
    }

    //This is the logout button
    function loginNavLogout()
    {
        return "Logout";
    }

    //This is the reader text for the notifications button
    function loginNavNotifications()
    {
        return "Notifications";
    }

    //This is the button for the forums and other community functions
    function loginNavCommunity()
    {
        return "Community";
    }

    //This is the button for the players profile page called the "Spirit" due to the story being about your spirit constantly living and dying
    function loginNavSpirit()
    {
        return "Spirit";
    }

    //This is the button for the admin page that will allow players to manage reports and create new maps, only players with the right privilege will be able to do this.
    function loginNavAdmin()
    {
        return "Admin";
    }

    //This is the messages popup that will tell you about any alerts
    function loginNavMessages()
    {
        return "Messages";
    }




    //POPUP THAT ALLOWS THE PLAYER TO LOGIN TO THE GAME

    //The button to take the player to the sign up page
    function loginScreenSignup()
    {
        return "Registrera dig nu";
    }

    //The text informing players where to log into the game
    function loginScreenConnect()
    {
        return "eller anslut";
    }

    //Tells players where to write their username
    function loginScrenUsername()
    {
        return "Ange användarnamn";
    }

    //Placeholder for the username input box
    function loginScreenUsernamePlaceholder()
    {
        return "Användarnamn";
    }

    //Tells the players where to write their password
    function loginScreenPassword()
    {
        return "Ange Lösenord";
    }

    //The placeholder for the password box
    function loginScreenPasswordPlaceholder()
    {
        return "Lösenord";
    }

    //This is the link to recover your password
    function loginScreenForgottenPassword()
    {
        return "Glömt lösenord?";
    }

    //This is the checkbox to have the website remember you using cookies
    function loginScreenRememberMe()
    {
        return "Kom ihåg mig";
    }

    //This is the confirm button to login to the game
    function loginScreenConfirm()
    {
        return "Logga in";
    }




    //POPUP FOR THE FORGOTTEN PASSWORD REQUEST

    //The instructions at the top of the forgotten boz
    function forgottenScreenDetails()
    {
        return "Ange den email du använde för att skapa ditt konto";
    }

    //The placeholder for the email box
    function forgottenScreenEmailPlaceholder()
    {
        return "Email Address";
    }

    //The details for the forgotten email box
    function forgottenScreenEmail()
    {
        return "Email Address";
    }

    //This is the button to confirm the email address used
    function forgottenScreenConfirm()
    {
        return "Skicka påminnelse!";
    }

    //This is the alternative to having a reminder sent
    function forgottenScreenOr()
    {
        return "----- Eller -----";
    }

    //This is the button for players to contact the administrator
    function forgottenScreenContact()
    {
        return "Kontakta Administratör";
    }

    //This is the text that will be sent within the email
    function forgottenScreenEmailPrep()
    {
        return 'mailto:admin@arctic-lands.com?Subject=Login%20Help&body=Please help me with my account!%0D%0A%0D%0AMy username is: <Insert Username>%0D%0A%0D%0AI think my email address is: <Insert Email Address>%0D%0A%0D%0AThe problem I\'m having is: <Insert problem here>';
    }




    //THE POPUP FOR THE SIGN UP WINDOW

    //This returns the player to the login popup
    function signupScreenLoginLink()
    {
        return "Redan Registrerad??";
    }

    //This is the placeholder for the username input
    function signupScreenUsernamePlaceholder()
    {
        return "Användarnamn";
    }

    //This is the writing for the username input
    function signupScreenUsername()
    {
        return "Ange Användarnamn";
    }

    //This is further details for the username input box
    function signupScreenUsernameDetails()
    {
        return "Användarnamn får ej innehålla special-karaktärer";
    }

    //This is the placeholder for the email input
    function signupScreenEmailPlaceholder()
    {
        return "Email Address";
    }

    //This is the writing for the email input box
    function signupScreenEmail()
    {
       return "Ange email address";
    }

    //This is further details for the email input box
    function signupScreenEmailDetails()
    {
        return "Verifikation email kommer att bli skickad till denna address";
    }

    //This is the placeholder for the password input
    function signupScreenPasswordPlaceholder()
    {
        return "Lösenord";
    }

    //This is the writing for the password input
    function signupScreenPassword()
    {
        return "Ange Lösenord";
    }

    //This is further details for the password input box
    function signupScreenPasswordDetails()
    {
        return "Lösenord borde vara över 6 karaktärer långt med en blandning av special-karaktärer, siffror och bokstäver";
    }

    //This is the placeholder for the 2nd password input
    function signupScreenPassword2Placeholder()
    {
        return "Bekräfta Lösenord";
    }

    //This is the writing for the 2nd password input
    function signupScreenPassword2()
    {
        return "Ange Lösenord";
    }

    //This is further details for the 2nd password input
    function signupScreenPassword2Details()
    {
        return "Försäkra dig att detta lösenord matchar med det första lösenordet";
    }

    //This is the confirm button for the sign up popup
    function signupScreenConfirm()
    {
        return "Registrera";
    }




    //TEXT ON THE FOOTER OF ALL PAGES

    //This is the name of the game
    function footerGameName()
    {
        return "Arctic Lands";
    }

    //This is the current version of the game
    function footerGameVersion()
    {
        return "Version: 6.3 (Alpha)";
    }

    //This is the title of the helpful links
    function footerHelpfulTitle()
    {
        return "Hjälpsamma Länkar";
    }

    //This is the link to the help page
    function footerHelpfulHelp()
    {
        return "Hjälp";
    }

    //This is the link to the wiki page
    function footerHelpfulWiki()
    {
        return "Wiki-sida";
    }

    //This is the link to the bug tracking page
    function footerHelpfulBug()
    {
        return "Felsökare";
    }

    //This is the title of the contact section
    function footerContactTitle()
    {
        return "Kontakta Oss";
    }

    //This is the creator of the game
    function footerContactCreator()
    {
        return "Maxmansung Spel";
    }

    //This is the link to the credits page
    function footerContactCredits()
    {
        return "Beröm och Heder";
    }
}

