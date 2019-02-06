DESCRIPTION
-------------------
Ubuxa chat app was built with the aim of enhancing the communication aspect of the ubuxa app, as such there was a need of adding some new technologies to the app to enable realtime communication between the server and the client. languages used (nodejs(server side),jquery(client side),express framework(server side), socket.io(server side), mongo(database) etc ), below is a full instruction on how to deploy ubuxa chat on both local host and on life server.


INSTALLATION ON LOCALHOST
-------------------------
Node.js(windows):
Node isn’t a program that you simply launch like Word or Photoshop: you won’t find it pinned to the taskbar or in your list of Apps. To use Node you must type command-line instructions, so you need to be comfortable with (or at least know how to start) a command-line tool like the Windows Command Prompt, PowerShell, Cygwin, or the Git shell (which is installed along with Github for Windows).

Installing Node and NPM is pretty straightforward using the installer package available from the Node.js® web site.

Installation Steps
1. Download the Windows installer from the Nodes.js® web site.
2. Run the installer (the .msi file you downloaded in the previous step.)
3. Follow the prompts in the installer (Accept the license agreement, click the NEXT button a bunch of times and accept the default installation settings).
4. Restart your computer. You won’t be able to run Node.js® until you restart your computer.

Make sure you have Node and NPM installed by running simple commands to see what version of each is installed and to run a simple test program

Test Node:
To see if Node is installed, open the Windows Command Prompt, Powershell or a similar command line tool, and type node -v. This should print a version number, so you’ll see something like this v0.10.35.

Test NPM:
To see if NPM is installed, type npm -v in Terminal. This should print NPM’s version number so you’ll see something like this 1.4.28
Create a test file and run it. A simple way to test that node.js works is to create a JavaScript file: name it hello.js, and just add the code console.log('Node is installed!');. To run the code simply open your command line program, navigate to the folder where you save the file and type node hello.js. This will start Node and run the code in the hello.js file. You should see the output Node is installed!.

Node.js(mac):

Before you install Node.js and NPM you’ll first need to have some familiarity with the Mac Terminal application. Terminal lets you dig into the underbelly of the operating system and issue text commands to your computer. You’ll need to use Terminal (or a similar application like iTerm) to not only install Node.js but also to use it and NPM.

Before you can install Node, you’ll need to install two other applications. Fortunately, once you’ve got these on your machine, installing Node takes just a few minutes.

1. XCode:
Apple’s XCode development software is used to build Mac and iOS apps, but it also includes the tools you need to compile software for use on your Mac. XCode is free and you can find it in the Apple App Store.
2. Homebrew:
Homebrew is a package manager for the Mac — it makes installing most open source sofware (like Node) as simple as writing brew install node. You can learn more about Homebrew at the Homebrew website. To install Homebrew just open Terminal and type ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)". You’ll see messages in the Terminal explaining what you need to do to complete the installation process.

Installation

Installing Node.js and NPM is pretty straightforward using Homebrew. Homebrew handles downloading, unpacking and installing Node and NPM on your system. The whole process (after you have XCode and Homebrew installed) should only take you a few minutes.

Open the Terminal app and type brew install node.
Sit back and wait. Homebrew downloads some files and installs them. And that’s it.
To make sure you have Node and NPM installed, run two simple commands to see what version of each is installed:

To see if Node is installed, type node -v in Terminal. This should print the version number so you’ll see something like this v0.10.31.
To see if NPM is installed, type npm -v in Terminal. This should print the version number so you’ll see something like this 1.4.27

MongoDB installation(windows)
follow link for full documentation (https://docs.mongodb.com/v3.2/tutorial/install-mongodb-on-windows/)
MongoDB installation(mac)
follow link for full documentation (https://treehouse.github.io/installation-guides/mac/mongo-mac.html)

INSTALLATION ON CLOUDSERVER
---------------------------
Node.js(linux):
Prerequisites
You should have some familiarity with the Linux terminal since you’ll need to use it to install and test Node and NPM. You’ll also need the terminal to use Node.js and NPM.
Dependencies. You need to install a number of dependancies before you can install Node.js and NPM.

1. Ruby and GCC:
You’ll need Ruby 1.8.6 or newer and GCC 4.2 or newer.
For Ubuntu or Debian-based Linux distributions, run the following command in your terminal: sudo apt-get install build-essential curl git m4 ruby texinfo libbz2-dev libcurl4-openssl-dev libexpat-dev libncurses-dev zlib1g-dev Then select Y to continue and wait for the packages to be installed.
For Fedora based Linux distributions run the following command in your terminal application: sudo yum groupinstall 'Development Tools' && sudo yum install curl git m4 ruby texinfo bzip2-devel curl-devel expat-devel ncurses-devel zlib-devel Then select Y to continue and wait for the packages to be installed.

2. Homebrew:
Homebrew is a package manager originally for the Mac, but it’s been ported to Linux as Linuxbrew, making installing most open-source software (like Node) as simple as writing: brew install node You can learn more about Homebrew at the Homebrew website and Linuxbrew at the Linuxbrew website. To install Homebrew for Linux, open your terminal application and paste in the command: ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/linuxbrew/go/install)" Follow the instructions in the terminal to complete the installation process.

Once Linuxbrew is installed, you’ll need add the following 3 lines to your .bashrc or .zshrc file:

export PATH="$HOME/.linuxbrew/bin:$PATH"
  export MANPATH="$HOME/.linuxbrew/share/man:$MANPATH"
  export INFOPATH="$HOME/.linuxbrew/share/info:$INFOPATH"
  
  Installation
  
Installing Node.js and NPM is pretty straightforward using Linuxbrew, the Linux port of Homebrew. It handles downloading, unpacking, compiling, and installing Node and NPM on your system. After you have Linuxbrew installed, the whole process should only take you a few minutes.

Open up your terminal and type brew install node.
Sit back and wait. Homebrew has to download some files, compile and install them. But that’s it.
Testing it out.
Make sure you have Node and NPM installed by running simple commands to see what version of each is installed:

1. Test Node.js:
To see if Node.js is installed, type node -v in the terminal. This should print the version number, so you’ll see something like this: v0.10.35.

2. Test NPM:
To see if NPM is installed, type npm -v in the terminal. This should print the version number, so you’ll see something like this: 2.1.17

MongoDB installation(linux)
follow link for full documentation (https://docs.mongodb.com/manual/administration/install-on-linux/)

UBUXA CHAT USAGE
-------------------
First unzip the project file .
On terminal run npm i --save socket.io express.

Start mongodb
cd to project directory/mondodb
run bin/mongod 
Start server
on the project directory run node ./appsjs or nodemon ./appsjs if nodemon is installed 



DIRECTORY STRUCTURE
-------------------

```
app
    controller/              contains all controllers
    models/              contains mogodb models
app.js 					main server file
libs
    chat.js/              main chat lib
                 
midlewares/ 			for user auth
        
nodemodules/			all node modles
                                          


TO DO
-------------------
1. video chat
2. namespace customer scope
3. read reciept 
4. chat settings
5. scroll to view history 
