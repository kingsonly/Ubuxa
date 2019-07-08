#### Epsolun Strategy For  Product development Division

1. Backend 
2. Mobile App / Website / Web App
3. Training

in the next 3 month the programing team are going to strongly be focusing on this 3 key point, we would be building a backend which would be used to manage the customers, making frequent patch for all available platforms and have a regular schedule for training and building our skills.

#### Backend 

The backend entails building a control panel for the non programing staffs to use in the management of ubuxa subscribers, code review , documentation and automated testing.

A. Ubuxa CRM/CMS:

 Users need to be managed and as such ubuxa needs a CRM to do that, the team would focus primarily on using exiting technologies in order to make the process faster.
 
 Detailed Possible functionality of ubuxa CRM/CMS
 
 i. Customer module: this module would be responsible for the entire management of both customers and users of the system, it would be responsible for billing management of customers, direct communication between the customers and the users under each customers, also it would be able to indicate most activities carried out within a customer account such as total number of folders, total numbers of task,  account logins and logout frequency etc
 
 ii. Log module : this module would be responsible for logging system errors, such as 404 and also be able to tell us the customer who experienced such error.
 
 iii. Feedback management module : this module would help in the easy management of feedback gotten from users of the system.
 
 iv. A/B testing control module : a/b testing  need to be controlled as such this module will help in determining which users should use new features or not .
 

B. Code review / Documentation

Before now the team has been on a race to deliver an MVP as such certain thing where neglected such as proper code documentation, some of the code where more like a reinventing of the wheel, as such the team would review and optimize the previously written codes.

The ubuxa software was built using different technologies and different backend languages as such there could be different approaches for different languages.

i. Php

	a. Coding standard: the coding standard would contain details as to how each script should be structured, to make the code pattern consistent .
		

    1. Code MUST use 4 spaces for indenting, not tabs.

    There MUST NOT be a hard limit on line length; the soft limit MUST be 120 characters; lines SHOULD be 80 characters or less.

   2.  There MUST be one blank line after the namespace declaration, and there MUST be one blank line after the block of use declarations. eg(
   		<?php
			namespace Vendor\Package;
			
			use FooClass;
			use BarClass as Bar;
			use OtherVendor\OtherPackage\BazClass;
			
			// ... additional PHP code ...
			)
		
   

    3. Opening braces for classes MUST go on the next line, and closing braces MUST go on the next line after the body. eg(
			<?php
		namespace Vendor\Package;

		use FooClass;
		use BarClass as Bar;
		use OtherVendor\OtherPackage\BazClass;

		class ClassName extends ParentClass implements \ArrayAccess, \Countable
		{
			// constants, properties, methods
		}
	)
	
	Lists of implements MAY be split across multiple lines, where each subsequent line is indented once. When doing so, the first item in the list MUST be on the next line, and there MUST be only one interface per line. eg(
	
		<?php
		namespace Vendor\Package;

		use FooClass;
		use BarClass as Bar;
		use OtherVendor\OtherPackage\BazClass;

		class ClassName extends ParentClass implements
			\ArrayAccess,
			\Countable,
			\Serializable
		{
			// constants, properties, methods
		}

	
	)
	

    4. Opening braces for methods MUST go on the next line, and closing braces MUST go on the next line after the body. eg(
		<?php
		namespace Vendor\Package;

		class ClassName
		{
			public function fooBarBaz($arg1, &$arg2, $arg3 = [])
			{
				// method body
			}
		}
	)
	
	In the argument list, there MUST NOT be a space before each comma, and there MUST be one space after each comma.

	Method arguments with default values MUST go at the end of the argument list.eg(
		<?php
		namespace Vendor\Package;

		class ClassName
		{
			public function foo($arg1, &$arg2, $arg3 = [])
			{
				// method body
			}
		}

	)
	
	Argument lists MAY be split across multiple lines, where each subsequent line is indented once. When doing so, the first item in the list MUST be on the next line, and there MUST be only one argument per line.

	When the argument list is split across multiple lines, the closing parenthesis and opening brace MUST be placed together on their own line with one space between them. eg(
	
		<?php
	namespace Vendor\Package;

	class ClassName
	{
		public function aVeryLongMethodName(
			ClassTypeHint $arg1,
			&$arg2,
			array $arg3 = []
		) {
			// method body
		}
	}

	)
	
	When present, the abstract and final declarations MUST precede the visibility declaration.

	When present, the static declaration MUST come after the visibility declaration.eg(
	
		<?php
		namespace Vendor\Package;

		abstract class ClassName
		{
			protected static $foo;

			abstract protected function zim();

			final public static function bar()
			{
				// method body
			}
		}

	)
	
	When making a method or function call, there MUST NOT be a space between the method or function name and the opening parenthesis, there MUST NOT be a space after the opening parenthesis, and there MUST NOT be a space before the closing parenthesis. In the argument list, there MUST NOT be a space before each comma, and there MUST be one space after each comma.eg(
		<?php
		bar();
		$foo->bar($arg1);
		Foo::bar($arg2, $arg3);
		
		)
		
	Argument lists MAY be split across multiple lines, where each subsequent line is indented once. When doing so, the first item in the list MUST be on the next line, and there MUST be only one argument per line.eg(
		<?php
		$foo->bar(
			$longArgument,
			$longerArgument,
			$muchLongerArgument
		);
	)


    5. Visibility MUST be declared on all properties and methods; abstract and final MUST be declared before the visibility; static MUST be declared after the visibility.eg(
		<?php
			namespace Vendor\Package;

			class ClassName
			{
				public $foo = null;
			}
		)
		


    6. Control structure keywords MUST have one space after them; method and function calls MUST NOT.
	
	Opening braces for control structures MUST go on the same line, and closing braces MUST go on the next line after the body.

   Opening parentheses for control structures MUST NOT have a space after them, and closing parentheses for control structures MUST NOT have a space before.
	
	An if structure looks like the following. Note the placement of parentheses, spaces, and braces; and that else and elseif are on the same line as the closing brace from the earlier body.eg(
		<?php
		if ($expr1) {
			// if body
		} elseif ($expr2) {
			// elseif body
		} else {
			// else body;
		}

	)
	
	
	A switch structure looks like the following. Note the placement of parentheses, spaces, and braces. The case statement MUST be indented once from switch, and the break keyword (or other terminating keyword) MUST be indented at the same level as the case body. There MUST be a comment such as // no break when fall-through is intentional in a non-empty case body.eg(
	
		<?php
	switch ($expr) {
		case 0:
			echo 'First case, with a break';
			break;
		case 1:
			echo 'Second case, which falls through';
			// no break
		case 2:
		case 3:
		case 4:
			echo 'Third case, return instead of break';
			return;
		default:
			echo 'Default case';
			break;
	}

	
	)
	
	A while statement looks like the following. Note the placement of parentheses, spaces, and braces.eg(
	
	<?php
	while ($expr) {
		// structure body
	}
	
	<?php
	do {
		// structure body;
	} while ($expr);

	)
	
	A for statement looks like the following. Note the placement of parentheses, spaces, and braces.eg(
		<?php
		for ($i = 0; $i < 10; $i++) {
			// for body
		}

	)
	
	A foreach statement looks like the following. Note the placement of parentheses, spaces, and braces.eg(
		<?php
		foreach ($iterable as $key => $value) {
			// foreach body
		}

	)
	
	A try catch block looks like the following. Note the placement of parentheses, spaces, and braces.
	<?php
		try {
			// try body
		} catch (FirstExceptionType $e) {
			// catch body
		} catch (OtherExceptionType $e) {
			// catch body
		}



    
	
	7. PHP keywords MUST be in lower case. eg(
		<?php ?>
	)
	
	8. Closures: Closures MUST be declared with a space after the function keyword, and a space before and after the use keyword.

The opening brace MUST go on the same line, and the closing brace MUST go on the next line following the body.

There MUST NOT be a space after the opening parenthesis of the argument list or variable list, and there MUST NOT be a space before the closing parenthesis of the argument list or variable list.

In the argument list and variable list, there MUST NOT be a space before each comma, and there MUST be one space after each comma.

Closure arguments with default values MUST go at the end of the argument list.

A closure declaration looks like the following. Note the placement of parentheses, commas, spaces, and braceseg(
	<?php
	$closureWithArgs = function ($arg1, $arg2) {
		// body
	};

	$closureWithArgsAndVars = function ($arg1, $arg2) use ($var1, $var2) {
		// body
	};

)

Argument lists and variable lists MAY be split across multiple lines, where each subsequent line is indented once. When doing so, the first item in the list MUST be on the next line, and there MUST be only one argument or variable per line.

When the ending list (whether of arguments or variables) is split across multiple lines, the closing parenthesis and opening brace MUST be placed together on their own line with one space between them.

The following are examples of closures with and without argument lists and variable lists split across multiple lines. eg(

	<?php
	$longArgs_noVars = function (
		$longArgument,
		$longerArgument,
		$muchLongerArgument
	) {
		// body
	};

	$noArgs_longVars = function () use (
		$longVar1,
		$longerVar2,
		$muchLongerVar3
	) {
		// body
	};

	$longArgs_longVars = function (
		$longArgument,
		$longerArgument,
		$muchLongerArgument
	) use (
		$longVar1,
		$longerVar2,
		$muchLongerVar3
	) {
		// body
	};

	$longArgs_shortVars = function (
		$longArgument,
		$longerArgument,
		$muchLongerArgument
	) use ($var1) {
		// body
	};

	$shortArgs_longVars = function ($arg) use (
		$longVar1,
		$longerVar2,
		$muchLongerVar3
	) {
		// body
	};

)


	b. Naming standard:In general, code is written once but read multiple times, by others in the project team or even those from other teams. Readability is therefore important. Readability is nothing more than figuring out what the code does in less time.
	Among the many best practices of coding, is the way variables, functions, classes and even files are named in a project. A common naming convention that everyone agrees to follow must be accompanied by consistent usage. This will result in developers, reviewers and project managers communicate effectively with respect to what the code does
	At Epsolun the preferred naming standard is the camel case naming convention
	
	i. Camel Case: First letter of every word is capitalized with no spaces or symbols between words. Examples: UserAccount, FedEx, WordPerfect. A variation common in programming is to start with a lower case: iPad, eBay, fileName, userAccount. Microsoft uses the term Camel Case to refer strictly to this variation. 
	
	ii. Categories of naming conventions: it's common to categorize a naming convention as one of these:
		a.Typographical: This relates to the use of letter case and symbols such as underscore, dot and hyphen.
		
		b. Grammatical: This relates to the semantics or the purpose. For example, classes should be nouns or noun phrases to identify the entity; methods and functions should be verbs or verb phrases to identify action performed; annotations can be any part of speech; interfaces should be adjectives. 
		
		Grammatical conventions are less important for variable names or instance properties. They are more important for classes, interfaces and methods that are often exposed as APIs
		
		At Epsolun the approved naming convention category would be the Grammatical naming convention.
	
	c. Testing framework: Automated testing : the ability to resolve bugs and issues faster in a big system is close to impossible in the absence of an automated testing system as such the team would have to devote a large amount of time in setting this issue right before moving on to other things .
	Codeception tests is going to be used for testing php as it is a standard recommendation of the yii framework team.
		usage (
		run ./vendor/bin/codecept run
		)
		UNIT TEST eg(
			<?php
			 
			// insert records in database
			$this->tester->haveRecord('app/model/User', ['username' => 'davert']);
			// check records in database
			$this->tester->seeRecord('app/model/User', ['username' => 'davert']);
			// test email was sent
			$this->tester->seeEmailIsSent();
			// get a last sent emails
			$this->tester->grabLastSentEmail();

		)
		
		FUNCTIONAL TEST eg(
			<?php
			$I->amOnPage(['site/contact']);
			$I->submitForm('#contact-form', []);
			$I->expectTo('see validations errors');
			$I->see('Contact', 'h1');
			$I->see('Name cannot be blank');
			$I->see('Email cannot be blank');
			$I->see('Subject cannot be blank');
			$I->see('Body cannot be blank');

		)
		
		Acceptance Test eg(
		
		$I->amOnPage(Url::toRoute('/site/index'));
		$I->expectTo("See some key elements on the page");
        $I->canSee('TycolMain');
        $I->canSee(['name' => 'login-button']);
        $I->canSee('Login');
		$I->seeCookie('ds');
		$I->login('admin', 'secreter');
		$I->click('About');
        $I->wait(2); // wait for page to be opened
		$I->see('This is the About page.');
		)
		
		
	d. Documentation: A good software is as good as the standard of its documentation as such the Epsolun team would have to establish a good commenting system.
	
	for php we would be using a yii2 extension which would help the documentation process faster (Yii's apidoc extension)
	
	requirement for Yii's apidoc extension
	i. installation 
	using composer "yiisoft/yii2-apidoc": "~2.1.0";
	
	This extension offers two commands:

    A. api to generate class API documentation.
    B. guide to render nice HTML pages from markdown files such as the yii guide.
	
	commenting style for using Yii's apidoc extension
	
	Basically, you create comments within your code that apidoc uses to build your documentation. It's described within the Yii coding style guide.

	You place a comment block at the top of each file like this one eg(
		<?php
		/**
		 * @link https://meetingplanner.io
		 * @copyright Copyright (c) 2016 Lookahead Consulting
		 * @license https://github.com/newscloud/mp/blob/master/LICENSE
		 */
	)
	
	And you place a comment block above each controller or model definition eg(
	/**
	 * UserTokenController provides API functionality for registration, delete and verify
	 *
	 * @author Jeff Reifman <jeff@meetingplanner.io>
	 * @since 0.1
	 */
	class UserTokenController extends Controller
	{}
	
	)
	
	Then, you place a detailed comment block above each method, which includes parameters, return values, and exceptions eg(
		/**
		 * Register a new user with an external social Oauth_token
		 *
		 * @param string $signature the hash generated with app_secret
		 * @param string $app_id in header, the shared secret application id
		 * @param string $email in header, email address
		 * @param string $firstname in header, first name
		 * @param string $lastname in header, last name
		 * @param string $oauth_token in header, the token returned from Facebook during OAuth for this user
		 * @param string $source in header, the source that the $oauth_token is from e.g. 'facebook' e.g. [$oauth_token]
		 * @return obj $identityObj with user_id and user_token
		 * @throws Exception not yet implemented
		 */
		 public function actionRegister($signature,$app_id='',$email='',$firstname ='',$lastname='',$oauth_token='',$source='') {}
	)
	
	Documentation style Guide 
	
	Tag 	Element 	Description
api 	Methods 	declares that elements are suitable for consumption by third parties.

author 	Any 	documents the author of the associated element.

category 	File, Class 	groups a series of packages together.

copyright 	Any 	documents the copyright information for the associated element.

deprecated 	Any 	indicates that the associated element is deprecated and can be removed in a future version.

example 	Any 	shows the code of a specified example file or, optionally, just a portion of it.

filesource 	File 	includes the source of the current file for use in the output.

global 	Variable 	informs phpDocumentor of a global variable or its usage.

ignore 	Any 	tells phpDocumentor that the associated element is not to be included in the documentation.

internal 	Any 	denotes that the associated elements is internal to this application or library and hides it 					 by default.

license 	File, Class 	indicates which license is applicable for the associated element.

link 	Any 	indicates a relation between the associated element and a page of a website.

method 	Class 	allows a class to know which ‘magic’ methods are callable.

package 	File, Class 	categorizes the associated element into a logical grouping or subdivision.

param 	Method, Function 	documents a single argument of a function or method.

property 	Class 	allows a class to know which ‘magic’ properties are present.

property-read 	Class 	allows a class to know which ‘magic’ properties are present that are read-only.

property-write 	Class 	allows a class to know which ‘magic’ properties are present that are write-only.

return 	Method, Function 	documents the return value of functions or methods.

see 	Any 	indicates a reference from the associated element to a website or other elements.

since 	Any 	indicates at which version the associated element became available.

source 	Any, except File 	shows the source code of the associated element.

subpackage 	File, Class 	categorizes the associated element into a logical grouping or subdivision.

throws 	Method, Function 	indicates whether the associated element could throw a specific type of exception.

todo 	Any 	indicates whether any development activity should still be executed on the associated element.

uses 	Any 	indicates a reference to (and from) a single associated element.

var 	Properties 	 

version 	Any 	indicates the current version of Structural Elements.


ii. Javascript

	A. Coding standard:
		i. Use 2 spaces for indentation eg (
			function hello (name) {
  			  console.log('hi', name)
			}
		)
		
		ii. Use single quotes for strings except to avoid escaping eg(
			console.log('hello there')
			$("<div class='box'>")
		)
		
		iii. No unused variables eg(
			function myFunction () {
			  var result = something()   // ✗ avoid
			}
		)
		
		iv. Add a space after keywords eg(
		 if (condition) { ... }   // ✓ ok
		 if(condition) { ... }    // ✗ avoid
		)
		
		v. Add a space before a function declaration's parentheses eg(
		function name (arg) { ... }   // ✓ ok
		function name(arg) { ... }    // ✗ avoid

		run(function () { ... })      // ✓ ok
		run(function() { ... })       // ✗ avoid
		)
		vi. Always use === instead of ==.
		Exception: obj == null is allowed to check for null || undefined eg(
		 if (name === 'John')   // ✓ ok
		if (name == 'John')    // ✗ avoid

		if (name !== 'John')   // ✓ ok
		if (name != 'John')    // ✗ avoid
		)
		vii. Infix operators must be spaced eg(
		// ✓ ok
		var x = 2
		var message = 'hello, ' + name + '!'

		// ✗ avoid
		var x=2
		var message = 'hello, '+name+'!'
		)
		vii. Commas should have a space after them eg(
		// ✓ ok
		var list = [1, 2, 3, 4]
		function greet (name, options) { ... }

		// ✗ avoid
		var list = [1,2,3,4]
		function greet (name,options) { ... }
		) ...... full list available in reference
	B. Naming standard: similar to that of php (refer to php namingstandards)
	
	C. Testing framework: we would be using Jasmine and kama for testing epsolun javascript codes 
	sample code (
		
		describe("A suite is just a function", function() {
		  var a;

		  it("and so is a spec", function() {
			a = true;

			expect(a).toBe(true);
		  });
		});

	)
	
	D. Documentation : JSDoc would be used for generating documentation for all javascript codes 
		JSDoc instalation (
			npm install -g jsdoc
		)
		
		Usage :
		If you installed JSDoc locally, the JSDoc command-line tool is available in ./node_modules/.bin. To generate documentation for the file yourJavaScriptFile.js:
		run (
			./node_modules/.bin/jsdoc yourJavaScriptFile.js
		)
		
		If you installed JSDoc globally, run the jsdoc command: run (
			jsdoc yourJavaScriptFile.js
		)
		
		JSDoc comments requirements:

		A JSDoc comment should begin with a slash (/) and two asterisks (*).
		Inline tags should be enclosed in braces: { @code this }.
		@desc Block tags should always start on their own line.
		eg(
		/**
		* A testJSDoc comment should begin with a slash and 2 asterisks.
		* Inline tags should be enclosed in braces like {@code this}.
		* @desc Block tags should always start on their own line.
		*/
		)
		
		note : link would be provided in the reference for more indepth explanation



 

### Mobile App / Website / Web App

it is quite pellucid that as we plan to move forward, there are still a few reasons to look backward at the already existing system as such the team would also focus a large amount of time to making useful modification to all 3 platform simultaneously to bring about of a beautiful users experience. sections which should be looked at include
A. Performance : As a result of the code review process there could be a need for the team to optimize either Mobile App / Website / Web App never the less users based on their review could trigger the team to look into the overall performance of either of the platform.

B. Users experience / users request : A Happy customer is equals to a good business as such its expected that from time to time the users may request a feature which does not presently exist on the system, never the less such request is subject to a review by the core team before implementation.

### Training
Continues Learning in any industry can never be over looked most especially in the tech industry as such the team would have to keep building on their capacity.


Nnamdis training path for Epsolun



1. Undertaking a python course for automation, data science and machine learning(1 month)

2. Undertaking a nodejs course for backend programming(2 weeks)

3. Undertaking javascript course for frontend development(1 week)

4. Undertaking a react native course to make me a mobile expert(1 week)

5. Testing(2 weeks)


Emeka's training path for Epsolun

1. Undertaking a node.js/Express course for backend programming(2 months)

2. Undertaking a socket.io course for realtime capabilities (2 weeks)

3. Undertaking javascript/react course for frontend development(1 month)

4. Undertaking a react native course to make me a more grounded mobile developer (2 week)

5. Testing(2 weeks)


kingsley's training path for Epsolun

1. Undertaking a node.js/Express course for backend programming(2 weeks)

2. Undertaking a socket.io course for realtime capabilities (2 weeks)

3. Undertaking javascript/react course for frontend development(2 weeks)

4. Undertaking a react native course to make me a more grounded mobile developer (2 week)

5. Testing suite for php/javascript/python (3 weeks)

6. Undertaking a python course for AI, data science and machine learning(1 month)

7. ITIL course for ICT related project management


How acquired knowledge should be implemented:

1. use acquired knowledge to automate some boring task

2. Add to Epsolun business intelligence unit using basic description/predictive analytic methods

3. Good modular backend development with nodejs for speed optimization in o(N) time

4. Rendering a super dynamic views with the power of javascript

5. Write functional test for our codebase.

6. Be able to use acquired knowledge to increase efficiency.

7. Be able to build complicated system and deliver on project time

8. be able to manage and evaluate the performance of the entire team or sub team



### Operational strategy

Backend / Mobile App / Website / Web App : Development would consist of 60% as it is our daily responsibility as such i recommend that the team would code extensively 3days in a week, which is Monday till Wednesday and still release a code patch in the space of two weeks as such it means there should be two new patch release per month. 

Code review / Documentation : review and documentation of previous work would be done once a week every Thursday the team would focus on optimizing the previous and new code, as such this simply means the Team have to finish their task by Wednesday to be able to focus on review and documentation, note that due to the fact the team would not be working on any thing new, testing would consume more of the teams time, meaning Monday and Tuesday for testing and Wednesday for code path

Training: previously it was a company tradition to set out Friday for staffs capacity building, as such that tradition would be started again, to enable staffs read from Friday into the weekend.

every last Saturday of the month the developers would have a two hours strategy meeting from 10-12 to plan for the next month.

##### Reference 
1. https://medium.com/@andrewgoldis/how-to-document-source-code-responsibly-2b2f303aa525 (basic understanding on why codes should be readable by humans)

2.  https://devopedia.org/naming-conventions (general naming convention)

3. https://www.corephp.com/blog/php-best-practices-that-you-must-follow/ (php best practice)

4. https://devdocs.magento.com/guides/v2.3/coding-standards/docblock-standard-javascript.html (JavaScript DocBlock standard)

5. https://docs.phpdoc.org/guides/docblocks.html(JavaScript DocBlock standard)

6. https://www.npmjs.com/package/jsdoc (npm module for jsdoc extention)

7. https://dev.to/akshendra/generating-documentation-on-the-fly-in-express-2652 (Generating documentation on the fly in express ).

8. https://code.tutsplus.com/tutorials/programming-with-yii-generating-documentation--cms-27899 ( Generating Documentation in yii2)

9. https://github.com/yiisoft/yii2/blob/master/docs/internals/core-code-style.md#documentation ( yii2 docblock)

10. https://www.php-fig.org/psr/psr-2/ ( PSR-2: Coding Style Guide )

11. https://jasmine.github.io/ ( test suite for javascript)

12. https://codeception.com/for/yii ( test suite for yii2)

13. https://blog.zipboard.co/nodejs-coding-style-guidelines-5386b7d57032 (NodeJS Coding Style Guidelines)

14. https://docs.npmjs.com/misc/coding-style.html (npm-coding-style )

15. https://github.com/standard/standard#i-disagree-with-rule-x-can-you-change-it (JavaScript Standard Style )

16. https://github.com/standard/standard/blob/master/RULES.md#javascript-standard-style ( JavaScript Standard Style with sample )

 
 