<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
include_once ($_SERVER['DOCUMENT_ROOT']."/MVC/data/languages/languageInterface.php");
class cowLanguage implements languageInterface
{
    function getFlag()
    {
        return "Cowville.png";
    }




    //THIS IS FOR THE TITLE PAGE PRIOR TO LOGGING INTO THE GAME

    //The first writing seen on the front page of the site
    function loginMasterPageTitle(){
        return "Moo moo moo...";
    }

    //Explanation text following the title on the front page
    function loginMasterPageWriting(){
        return "Moo mo moo moo-moo moooooooo, mooo moo moo MOOO mooo moo mooo. Moo mooo moo moo Mooo-Moo moo moo moo moo moo. MOO!
            <br><br>
            Moo moo moo mooo mooooo moo moo moo moo moo moo?";
    }

    //This is the button suggesting to play (All in capitals)
    function loginMasterPagePlayNow(){
        return "MOO MOO";
    }

    //This is the button to sign up to the game
    function loginMasterPageSignupFree()
    {
        return "MOO MO MOOO";
    }

    //This is the title to the text describing the page
    function loginMasterPageAboutTitle()
    {
        return "Moo moo moo-moo";
    }

    //These discuss different ways to play the game. Var 1 is the title and the rest is the description
    //Description 1 look at solo play
    function loginMasterPageDescription1($var)
    {
        if($var === 1){
            return "Moo mooo mo...";
        }
        else {
            return "Moo mo moo moo-moo moooooooo, mooo moo moo MOOO mooo moo mooo. Moo mooo moo moo Mooo-Moo moo moo moo moo moo. MOO! Moo moo moomoo moo Moo mo, moo moo moo moo mooooo moo-moo.";
        }
    }

    //Description 2 look s at group play
    function loginMasterPageDescription2($var)
    {
        if($var === 1){
            return "Mooooo...";
        }
        else {
            return "Mooo MOOO! Moo moo moo mooo moo moo moo-moo, moo Moo moo moo moo moo moo moo moo, moo moo moo. Moo? Moo moo moo moo";
        }
    }

    //Description 3 looks at trying to unite and entire map
    function loginMasterPageDescription3($var)
    {
        if($var === 1){
            return "Moo Moo...";
        }
        else {
            return "Moo moo moo moo moo moo moo. Moo moo moo moo moo moo moo. Moooo moo moo moo, moo moo-MOO moo moo moo mooooo moo moo moo moo Moo Moo moo mooooo moo moo moo moo. Moo moo moo moo moo moo.";
        }
    }

    //Description 4 about trying to tear the world apart
    function loginMasterPageDescription4($var)
    {
        if($var === 1){
            return "MOO mooo...";
        }
        else {
            return "Moo moo moo mooo mo MOOO moo! Moo moo moo momoo moo moo-oo moo moo mooo moomoo moo moo, moo-moo, moo Moo. MOO!";
        }
    }

    //This suggests to people about playing the game on their phone or tabled too
    function loginMasterPageOnPhone($var)
    {
        if($var === 1){
            return "Moo moo moo moo moo Mooo!";
        }
        else {
            return "Moo moo  moo moo  moo moo moo! Moo moo  moo moo  moo moo MOO  moo moo  moo moo moo. moo moo  moo moo  moo moo  moo moo  moo moo moo moo moo moo moo moo moo moo moo.
            <br><br>
                Moo moo  moo moo  moo moo moo. Moo moo  moo moo  moo moo  moo moo  moo moo moo. moo moo  moo moo  moo moo  moo moo  moo moo moo moo moo moo moo moo moo moo moo! Moo moo  moo moo  moo moo moo. Moo moo  moo moo  moo moo  moo moo  moo moo moo. moo moo  moo moo  moo moo  moo moo  moo moo moo moo moo moo moo moo moo moo moo...
                <br><br>
                Moo moo moo? Moo mooo moo Moo MOO!";
        }
    }






    //THIS IS FOR THE TITLE BANNER OF THE LOGIN PAGE

    //This is the login button on the banner
    function loginNavLogin()
    {
        return "Moo moo";
    }

    //This is the sign up button on the banner (In capitals)
    function loginNavSignup()
    {
        return "MOO MOO";
    }

    //One of the nav bar links, links to playing the game
    function loginNavPlay()
    {
        return "Moo";
    }

    //Nav bar link to the wiki with further details about the game
    function loginNavWiki()
    {
        return "Moo";
    }

    //Nav bar link to the blog page that will give further details about game development of the game
    function loginNavBlog()
    {
        return "Moo";
    }

    //Nav bar link that allows you to change your language
    function loginNavLanguage()
    {
        return "Moooo";
    }

    //This is the logout button
    function loginNavLogout()
    {
        return "Moo-Moo";
    }

    //This is the reader text for the notifications button
    function loginNavNotifications()
    {
        return "Mooooooo";
    }

    //This is the button for the forums and other community functions
    function loginNavCommunity()
    {
        return "Momoo";
    }

    //This is the button for the players profile page called the "Spirit" due to the story being about your spirit constantly living and dying
    function loginNavSpirit()
    {
        return "Moo!";
    }

    //This is the button for the game leaderboards page
    function loginNavScore()
    {
        return "Mooos";
    }

    //This is the button for the admin page that will allow players to manage reports and create new maps, only players with the right privilege will be able to do this.
    function loginNavAdmin()
    {
        return "Momomoo";
    }

    //This is the messages popup that will tell you about any alerts
    function loginNavMessages()
    {
        return "Moo";
    }




    //POPUP THAT ALLOWS THE PLAYER TO LOGIN TO THE GAME

    //The button to take the player to the sign up page
    function loginScreenSignup()
    {
        return "Moo moo moo";
    }

    //The text informing players where to log into the game
    function loginScreenConnect()
    {
        return "moo Moooo";
    }

    //Tells players where to write their username
    function loginScrenUsername()
    {
        return "Moo mooo-moo";
    }

    //Placeholder for the username input box
    function loginScreenUsernamePlaceholder()
    {
        return "Mooo-moo";
    }

    //Tells the players where to write their password
    function loginScreenPassword()
    {
        return "Moo moooo";
    }

    //The placeholder for the password box
    function loginScreenPasswordPlaceholder()
    {
        return "Moooo";
    }

    //This is the link to recover your password
    function loginScreenForgottenPassword()
    {
        return "Moo moooo?";
    }

    //This is the checkbox to have the website remember you using cookies
    function loginScreenRememberMe()
    {
        return "Mooo mo";
    }

    //This is the confirm button to login to the game
    function loginScreenConfirm()
    {
        return "Moo";
    }




    //POPUP FOR THE FORGOTTEN PASSWORD REQUEST

    //The instructions at the top of the forgotten boz
    function forgottenScreenDetails()
    {
        return "Moo moo moo moo mooo moo-moo";
    }

    //The placeholder for the email box
    function forgottenScreenEmailPlaceholder()
    {
        return "Mooo moo";
    }

    //The details for the forgotten email box
    function forgottenScreenEmail()
    {
        return "Mooo mooo";
    }

    //This is the button to confirm the email address used
    function forgottenScreenConfirm()
    {
        return "Moo mooo!";
    }

    //This is the alternative to having a reminder sent
    function forgottenScreenOr()
    {
        return "----- Mo -----";
    }

    //This is the button for players to contact the administrator
    function forgottenScreenContact()
    {
        return "Mooo moo moo mooo moo";
    }

    //This is the text that will be sent within the email
    function forgottenScreenEmailPrep()
    {
        return 'mailto:admin@arctic-lands.com?Subject=Moo moo%20Help&body=Moo moo mooo moo-Moo moo!%0D%0A%0D%0AMoo moo moo moo: <Moo Moo-moo>%0D%0A%0D%0AMoo moo mo moo moo: <Moo Moo Moooo>%0D%0A%0D%0AMoo moo moo moooo: <Moo moo Moo>';
    }




    //THE POPUP FOR THE SIGN UP WINDOW

    //This returns the player to the login popup
    function signupScreenLoginLink()
    {
        return "Mooo mooooo?";
    }

    //This is the placeholder for the username input
    function signupScreenUsernamePlaceholder()
    {
        return "Moo-moo";
    }

    //This is the writing for the username input
    function signupScreenUsername()
    {
        return "Moo moo-moo";
    }

    //This is further details for the username input box
    function signupScreenUsernameDetails()
    {
        return "Moo-moo moo moo moo mooo";
    }

    //This is the placeholder for the email input
    function signupScreenEmailPlaceholder()
    {
        return "Moo mooo";
    }

    //This is the writing for the email input box
    function signupScreenEmail()
    {
        return "Mooo moo moo moo";
    }

    //This is further details for the email input box
    function signupScreenEmailDetails()
    {
        return "Moo moo moo moo moo moo moo moo";
    }

    //This is the placeholder for the password input
    function signupScreenPasswordPlaceholder()
    {
        return "Moooo";
    }

    //This is the writing for the password input
    function signupScreenPassword()
    {
        return "Mooo moooo";
    }

    //This is further details for the password input box
    function signupScreenPasswordDetails()
    {
            return "Moo moo moo moo moo, moo, moo moo";
    }

    //This is the placeholder for the 2nd password input
    function signupScreenPassword2Placeholder()
    {
        return "Moo moooo";
    }

    //This is the writing for the 2nd password input
    function signupScreenPassword2()
    {
        return "Moo moooo";
    }

    //This is further details for the 2nd password input
    function signupScreenPassword2Details()
    {
        return "Moo moo moo moo moo moo moo moo";
    }

    //This is the confirm button for the sign up popup
    function signupScreenConfirm()
    {
        return "Mooo";
    }




    //TEXT ON THE FOOTER OF ALL PAGES

    //This is the name of the game
    function footerGameName()
    {
        return "Arctic Moo";
    }

    //This is the current version of the game
    function footerGameVersion()
    {
        return "Moo: 6.3 (moo)";
    }

    //This is the title of the helpful links
    function footerHelpfulTitle()
    {
        return "Moo moo";
    }

    //This is the link to the help page
    function footerHelpfulHelp()
    {
        return "Moo";
    }

    //This is the link to the wiki page
    function footerHelpfulWiki()
    {
        return "Moo moo";
    }

    //This is the link to the bug tracking page
    function footerHelpfulBug()
    {
        return "Moo moo";
    }

    //This is the link to the news page
    function footerHelpfulNews()
    {
        return "Moos";
    }

    //This is the title of the contact section
    function footerContactTitle()
    {
        return "Moo moo";
    }

    //This is the creator of the game
    function footerContactCreator()
    {
        return "Moomanmoo Games";
    }

    //This is the link to the credits page
    function footerContactCredits()
    {
        return "Mooo";
    }

    //This is the link to the Twitter page
    function footerTwitterLink()
    {
        return "Moo @MooMooGame";
    }



    // TEXT ON THE FORUM PAGE

    //The text about the type of forum page
    function forumThreadsTitle($var)
    {
        switch ($var){
            case "g":
                return "General Mooo";
                break;
            case "mx":
                return "Map Mooo";
                break;
            case "pc":
                return "Party Mooo";
                break;
            default:
                return "";
                break;
        }
    }

    //The title of the forums page
    function forumThreadsForums()
    {
        return "Mooo";
    }

    //The button to search for a thread
    function forumThreadsSearch()
    {
        return "Moo";
    }

    //The button to refresh the threads list
    function forumThreadsRefresh()
    {
        return "Moomoo";
    }

    //The button to create a new thread
    function forumThreadsNewThread()
    {
        return "Moo Moooo";
    }

    //Information about the original posting of the thread
    function forumThreadsThreads()
    {
        return "Moooo";
    }

    //Information about the responses a thread has received
    function forumThreadsResponses()
    {
        return "Moo's";
    }

    //These are the threads at the top of the page
    function forumThreadsPriorityThreads()
    {
        return "Moo Mooo";
    }


    //THE POPUP BOX THAT APPEARS WHEN YOU TRY TO REPORT A THREAD OR POST

    //The list of reasons for reporting another player
    function forumReportingReasons($var)
    {
        switch($var){
            case 0:
                return "Moo: ";
                break;
            case 1:
                return "Mooo!!";
                break;
            case 2:
                return "MOO moo";
                break;
            case 3:
                return "Moo?";
                break;
            default:
                return "";
                break;
        }
    }

    //The title for players to describe the report
    function forumReportingInformation()
    {
        return "Moo moo-moo moo:";
    }

    //Information about the character limit for the report description
    function forumReportingInformationDescription()
    {
        return "Moo 500 mooo";
    }
}

