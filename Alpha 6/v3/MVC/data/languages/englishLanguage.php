<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
include_once ($_SERVER['DOCUMENT_ROOT']."/MVC/data/languages/languageInterface.php");
class englishLanguage implements languageInterface
{
    function getFlag()
    {
        return "United%20Kingdom.png";
    }




    //THIS IS FOR THE TITLE PAGE PRIOR TO LOGGING INTO THE GAME

    //The first writing seen on the front page of the site
    function loginMasterPageTitle(){
        return "Its a wonderful afterlife...";
    }

    //Explanation text following the title on the front page
    function loginMasterPageWriting(){
        return "You wake up in the snow again, unsure of where you are or whats around. All you know is that you're dead. Turns out there is an afterlife, unfortunately that afterlife is a never ending cycle of dying and being reborn in the empty wastelands.
            <br><br>
            Can you do enough to please the gods of this hell and eventually find peace?";
    }

    //This is the button suggesting to play (All in capitals)
    function loginMasterPagePlayNow(){
        return "PLAY NOW";
    }

    //This is the button to sign up to the game
    function loginMasterPageSignupFree()
    {
        return "SIGN UP FREE";
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
            return "Communicate with the rest of the map and work to unite the world. Perhaps together you can overcome this cycle and find peace?<br><br>Do you trust those around you enough to open your gates and let in the masses though?";
        }
    }

    //Description 4 about trying to tear the world apart
    function loginMasterPageDescription4($var)
    {
        if($var === 1){
            return "Tear it apart...";
        }
        else {
            return "Destroy the land around you as you scrape every last resource out of it. Dig, explode and even summon the will of the gods until all that remains is the cold hard stone below your feet.";
        }
    }

    //This suggests to people about playing the game on their phone or tabled too
    function loginMasterPageOnPhone($var)
    {
        if($var === 1){
            return "On your phone or your tablet!";
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
        return "Log in";
    }

    //This is the sign up button on the banner (In capitals)
    function loginNavSignup()
    {
        return "SIGN UP";
    }

    //One of the nav bar links, links to playing the game
    function loginNavPlay()
    {
        return "Play";
    }

    //Nav bar link to the wiki with further details about the game
    function loginNavWiki()
    {
        return "Help";
    }

    //Nav bar link to the blog page that will give further details about game development of the game
    function loginNavBlog()
    {
        return "Blog";
    }

    //Nav bar link that allows you to change your language
    function loginNavLanguage()
    {
        return "Language";
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

    //This is the button for the game leaderboards page
    function loginNavScore()
    {
        return "Leaderboard";
    }

    //This is the button for the admin page that will allow players to manage reports and create new maps, only players with the right privilege will be able to do this.
    function loginNavAdmin()
    {
        return "Advanced";
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
        return "Sign up now";
    }

    //The text informing players where to log into the game
    function loginScreenConnect()
    {
        return "or connect";
    }

    //Tells players where to write their username
    function loginScrenUsername()
    {
        return "Enter username";
    }

    //Placeholder for the username input box
    function loginScreenUsernamePlaceholder()
    {
        return "Username";
    }

    //Tells the players where to write their password
    function loginScreenPassword()
    {
        return "Enter password";
    }

    //The placeholder for the password box
    function loginScreenPasswordPlaceholder()
    {
        return "Password";
    }

    //This is the link to recover your password
    function loginScreenForgottenPassword()
    {
        return "Forgotten Password?";
    }

    //This is the checkbox to have the website remember you using cookies
    function loginScreenRememberMe()
    {
        return "Remember Me";
    }

    //This is the confirm button to login to the game
    function loginScreenConfirm()
    {
        return "Login";
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
        return "Send reminder!";
    }

    //This is the alternative to having a reminder sent
    function forgottenScreenOr()
    {
        return "----- Or -----";
    }

    //This is the button for players to contact the administrator
    function forgottenScreenContact()
    {
        return "Contact the admins";
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
        return "Already registered?";
    }

    //This is the placeholder for the username input
    function signupScreenUsernamePlaceholder()
    {
        return "Username";
    }

    //This is the writing for the username input
    function signupScreenUsername()
    {
        return "Enter username";
    }

    //This is further details for the username input box
    function signupScreenUsernameDetails()
    {
        return "Usernames must not contain special characters";
    }

    //This is the placeholder for the email input
    function signupScreenEmailPlaceholder()
    {
        return "Email Address";
    }

    //This is the writing for the email input box
    function signupScreenEmail()
    {
       return "Enter email address";
    }

    //This is further details for the email input box
    function signupScreenEmailDetails()
    {
        return "Verification emails will be sent to this address";
    }

    //This is the placeholder for the password input
    function signupScreenPasswordPlaceholder()
    {
        return "Password";
    }

    //This is the writing for the password input
    function signupScreenPassword()
    {
        return "Enter password";
    }

    //This is further details for the password input box
    function signupScreenPasswordDetails()
    {
        return "Passwords should be 6+ chars with a mixture of special characters, numbers and letters";
    }

    //This is the placeholder for the 2nd password input
    function signupScreenPassword2Placeholder()
    {
        return "Confirm Password";
    }

    //This is the writing for the 2nd password input
    function signupScreenPassword2()
    {
        return "Enter Password";
    }

    //This is further details for the 2nd password input
    function signupScreenPassword2Details()
    {
        return "Ensure this password completely matches the first password";
    }

    //This is the confirm button for the sign up popup
    function signupScreenConfirm()
    {
        return "Register";
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
        return "Helpful Links";
    }

    //This is the link to the help page
    function footerHelpfulHelp()
    {
        return "Help";
    }

    //This is the link to the wiki page
    function footerHelpfulWiki()
    {
        return "Wiki page";
    }

    //This is the link to the bug tracking page
    function footerHelpfulBug()
    {
        return "Bug Tracker";
    }

    //This is the link to the news page
    function footerHelpfulNews()
    {
        return "News";
    }

    //This is the title of the contact section
    function footerContactTitle()
    {
        return "Contact Us";
    }

    //This is the creator of the game
    function footerContactCreator()
    {
        return "Maxmansung Games";
    }

    //This is the link to the credits page
    function footerContactCredits()
    {
        return "Credits";
    }

    //This is the link to the credits page
    function footerTwitterLink()
    {
        return "Twitter @ArcticLandsGame";
    }



    // TEXT ON THE FORUM PAGE

    //The text about the type of forum page
    function forumThreadsTitle($var)
    {
        switch ($var){
            case "g":
                return "General Chat";
                break;
            case "mx":
                return "Map Chat";
                break;
            case "pc":
                return "Party Chat";
                break;
            default:
                return "";
                break;
        }
    }

    //The title of the forums page
    function forumThreadsForums()
    {
        return "Forums";
    }

    //The button to search for a thread
    function forumThreadsSearch()
    {
        return "Search";
    }

    //The button to refresh the threads list
    function forumThreadsRefresh()
    {
        return "Refresh";
    }

    //The button to create a new thread
    function forumThreadsNewThread()
    {
        return "New Subject";
    }

    //Information about the original posting of the thread
    function forumThreadsThreads()
    {
        return "Subjects";
    }

    //Information about the responses a thread has received
    function forumThreadsResponses()
    {
        return "Responses";
    }

    //These are the threads at the top of the page
    function forumThreadsPriorityThreads()
    {
        return "Important threads";
    }


    //THE POPUP BOX THAT APPEARS WHEN YOU TRY TO REPORT A THREAD OR POST

    //The list of reasons for reporting another player
    function forumReportingReasons($var)
    {
        switch($var){
            case 0:
                return "Reason: ";
                break;
            case 1:
                return "Bad Language";
                break;
            case 2:
                return "Abusive";
                break;
            case 3:
                return "Other";
                break;
            default:
                return "";
                break;
        }
    }

    //The title for players to describe the report
    function forumReportingInformation()
    {
        return "Further information:";
    }

    //Information about the character limit for the report description
    function forumReportingInformationDescription()
    {
        return "Maximum 500 char";
    }
}

