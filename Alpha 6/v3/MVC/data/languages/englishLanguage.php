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

    //These discuss different ways to play the game. Var 1 is the title and the rest is the description
    //Description 1 look at solo play
    function loginMasterPageDescription1($var)
    {
        if($var === 1){
            return "By yourself...";
        }
        else {
            return "Lorem ipsum dolor sit amet, at solet voluptua eos, ei natum facilisis constituam mea. Liber admodum eam id. Id has munere ridens, ut quidam aeterno utroque eos. Sit cu veniam.";
        }
    }

    //Description 2 look s at group play
    function loginMasterPageDescription2($var)
    {
        if($var === 1){
            return "In a team...";
        }
        else {
            return "Lorem ipsum dolor sit amet, et propriae apeirian mediocrem vel, quo ut atqui petentium accommodare. No quot virtute alterum sea, an vim zril alterum, cum aperiam reformidans no. Case prompta.";
        }
    }

    //Description 3 is still being decided on currently
    function loginMasterPageDescription3($var)
    {
        if($var === 1){
            return "Bla bla...";
        }
        else {
            return "An sed minimum reprehendunt, pertinacia liberavisse cu eum, prima liber est te. Ex mea ludus suscipit aliquando, nam no dolor pertinacia, ne mel alienum sensibus. Ei singulis interesset his, mel.";
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
}

