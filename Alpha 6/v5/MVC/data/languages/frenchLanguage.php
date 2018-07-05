<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
include_once ($_SERVER['DOCUMENT_ROOT']."/MVC/data/languages/languageInterface.php");
class frenchLanguage implements languageInterface
{
    function getFlag()
    {
        return "France.png";
    }




    //THIS IS FOR THE TITLE PAGE PRIOR TO LOGGING INTO THE GAME

    //The first writing seen on the front page of the site
    function loginMasterPageTitle(){
        return "Its a wonderful afterlife...";
    }

    //Explanation text following the title on the front page
    function loginMasterPageWriting(){
        return "Vous vous réveillez dans la neige encore une fois, incertain d'où vous êtes. Tout ce que vous savez, c'est que vous êtes mort. Il s'avère qu'il ya une vie après la mort, malheureusement celle-ci consiste en un cycle sans fin. Mourir et renaître dans ces terres inconnues.            <br><br>
            Trouverez-vous le moyen de plaire aux Dieux de cet enfer et, éventuellement, de trouver la paix?";
    }

    //This is the button suggesting to play (All in capitals)
    function loginMasterPagePlayNow(){
        return "JOUER";
    }

    //This is the button to sign up to the game
    function loginMasterPageSignupFree()
    {
        return "INSCRIPTION";
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
            return "Sur votre téléphone ou votre tablette!";
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
        return "Se connecter";
    }

    //This is the sign up button on the banner (In capitals)
    function loginNavSignup()
    {
        return "INSCRIPTION";
    }

    //One of the nav bar links, links to playing the game
    function loginNavPlay()
    {
        return "Jouer";
    }

    //Nav bar link to the wiki with further details about the game
    function loginNavWiki()
    {
        return "Wiki";
    }

    //Nav bar link to the blog page that will give further details about game development of the game
    function loginNavBlog()
    {
        return "Blogue";
    }

    //Nav bar link that allows you to change your language
    function loginNavLanguage()
    {
        return "Langage";
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
        return "S'inscrire maintenant";
    }

    //The text informing players where to log into the game
    function loginScreenConnect()
    {
        return "ou se connecter";
    }

    //Tells players where to write their username
    function loginScrenUsername()
    {
        return "Votre pseudo";
    }

    //Placeholder for the username input box
    function loginScreenUsernamePlaceholder()
    {
        return "Pseudo";
    }

    //Tells the players where to write their password
    function loginScreenPassword()
    {
        return "Votre mot de passe";
    }

    //The placeholder for the password box
    function loginScreenPasswordPlaceholder()
    {
        return "Mot de passe";
    }

    //This is the link to recover your password
    function loginScreenForgottenPassword()
    {
        return "Mot de passe oublié?";
    }

    //This is the checkbox to have the website remember you using cookies
    function loginScreenRememberMe()
    {
        return "Se souvenir de moi";
    }

    //This is the confirm button to login to the game
    function loginScreenConfirm()
    {
        return "Connexion";
    }




    //POPUP FOR THE FORGOTTEN PASSWORD REQUEST

    //The instructions at the top of the forgotten boz
    function forgottenScreenDetails()
    {
        return "Please type the email used to create your account";
    }

    //The placeholder for the email box
    function forgottenScreenEmailPlaceholder()
    {
        return "Adresse e-mail";
    }

    //The details for the forgotten email box
    function forgottenScreenEmail()
    {
        return "Adresse e-mail";
    }

    //This is the button to confirm the email address used
    function forgottenScreenConfirm()
    {
        return "Envoyer un rappel!";
    }

    //This is the alternative to having a reminder sent
    function forgottenScreenOr()
    {
        return "----- Ou -----";
    }

    //This is the button for players to contact the administrator
    function forgottenScreenContact()
    {
        return "Contacter les adminstrateurs";
    }

    //This is the text that will be sent within the email
    function forgottenScreenEmailPrep()
    {
        return 'mailto:admin@arctic-lands.com?Subject=Login%20Help&body=S\'il vous plaît, aider-moi avec mon compte!%0D%0A%0D%0AMon pseudo est: <Insérer Pseudo>%0D%0A%0D%0AJe pense que l\'adresse e-mail associé à ce compte est: <Insérer Adresse e-mail>%0D%0A%0D%0ALe problème est le suivant: <Insérer une description du problème ici>';
    }




    //THE POPUP FOR THE SIGN UP WINDOW

    //This returns the player to the login popup
    function signupScreenLoginLink()
    {
        return "Déjà inscrit?";
    }

    //This is the placeholder for the username input
    function signupScreenUsernamePlaceholder()
    {
        return "Pseudo";
    }

    //This is the writing for the username input
    function signupScreenUsername()
    {
        return "Votre pseudo";
    }

    //This is further details for the username input box
    function signupScreenUsernameDetails()
    {
        return "Le pseudo ne doit pas contenir de caractère spéciaux";
    }

    //This is the placeholder for the email input
    function signupScreenEmailPlaceholder()
    {
        return "Adresse e-mail";
    }

    //This is the writing for the email input box
    function signupScreenEmail()
    {
       return "Votre adresse e-mail";
    }

    //This is further details for the email input box
    function signupScreenEmailDetails()
    {
        return "Un email de vérification vous sera envoyé à cette adresse";
    }

    //This is the placeholder for the password input
    function signupScreenPasswordPlaceholder()
    {
        return "Mot de passe";
    }

    //This is the writing for the password input
    function signupScreenPassword()
    {
        return "Votre mot de passe";
    }

    //This is further details for the password input box
    function signupScreenPasswordDetails()
    {
        return "Votre mot de passe doit avoir plus de 6 caractères avec un mélange de caractères spéciaux, de chiffres et de lettres";
    }

    //This is the placeholder for the 2nd password input
    function signupScreenPassword2Placeholder()
    {
        return "Confirmer votre mot de passe";
    }

    //This is the writing for the 2nd password input
    function signupScreenPassword2()
    {
        return "Votre mot de passe";
    }

    //This is further details for the 2nd password input
    function signupScreenPassword2Details()
    {
        return "Assurez-vous que ce soit le même que ci-dessus.";
    }

    //This is the confirm button for the sign up popup
    function signupScreenConfirm()
    {
        return "S'inscrire";
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
        return "Liens utiles";
    }

    //This is the link to the help page
    function footerHelpfulHelp()
    {
        return "Aide";
    }

    //This is the link to the wiki page
    function footerHelpfulWiki()
    {
        return "Page Wiki";
    }

    //This is the link to the bug tracking page
    function footerHelpfulBug()
    {
        return "Bug Tracker";
    }

    //This is the title of the contact section
    function footerContactTitle()
    {
        return "Nous contacter";
    }

    //This is the creator of the game
    function footerContactCreator()
    {
        return "Maxmansung Games";
    }

    //This is the link to the credits page
    function footerContactCredits()
    {
        return "Crédits";
    }
}

