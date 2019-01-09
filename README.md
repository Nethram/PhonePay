Phone Pay
===========
Phone Pay is a software tool written in PHP which helps you to collect payments from your clients via phone calls. It is suitable for use in any online or offline stores selling products or services. 
Phone Pay provides an interactive voice response system with the assigned Twilio phone number and the payment is made through Twilio Pay connected with Stripe.  

Key Features
------------  

-Detailed call and transaction log.  
-One click refund. 
-One click overage charging.  
-Configurable system behaviour.  
-Simple installation.  
-Easy to use Admin Panel.    
-Responsive design.  

..............................................

Prerequisite
------------  
-PHP,MySql  
-Stripe Account  
-Twilio Phone number  

...............................................

Installation
------------  
Befor starting installation you must connect your Stripe account to Twilio's Stripe Connect platform and enbale PCI mode in Twilio. For this, do below steps in order.
1. Enbale PCI Mode,
	Navigate to the Twilio Voice Settings Console Page and Enable PCI Mode, opt-in to Twilio's Terms of Service and click SAVE. 
2. connect your Stripe account to Twilio's Stripe Connect platform,
	Navigate to <Pay> Connectors under Programmable Voice and click on the Stripe tile.

		1. Click on Install.
		2. Now set the Stripe Connector unique name to Default. You can create one <Pay> Connector per Twilio account with the name Default. 
		3. Click on "Connect with Stripe" which will redirect over to Stripe and ask you to enter your credentials. At the end, your Stripe account will be connected with the Twilio Stripe Connect Platform. If your Stripe account has not been activated to allow you to accept payments in live mode, then you can bypass entering your business details at this point and simply click the link at the top "Skip this account form". You will be redirected back to Twilio now.
		4. Notice the Stripe account ID (acct_xxxxxx) is shown.

	That's all for configuring <Pay> Connectors! 
Now you can begin installation as below,

	Copy all files in to your web directory and open it in your favourite web browser. Phone Pay's installer GUI will help you in completing installation.
	During installation you will be asked to enter Database credentials and stripe keys. After completing installation you have to setup 
	Twilio number by changing its Request URL in your Twilio account. 



How to use
----------  
 Users calling to your Twilio number will be answered by Phone Pay's interactive voice response system (IVR) and lead to pay through Twilio Pay connected with Strip. User will be prompted to enter credit card details by IVR. Phone Pay made as PCI compliant with the help of Twilio Pay. Hence credit card details will not be passed to the server. All call logs and payment details will be available in Admin Panel. Admin can manage orders and also if needed, refund the amount to the payer.

Phone Pay can be configured in four different modes called system behavior. System behavior is switchable based on your needs at any time from admin panel.The four system behaviors are as follows.  

1-Fixed Payment with Order ID  

 Admin fixes an amount for all payments.  User will be asked to enter Order ID and then lead to pay the fixed amount.   Also admin can create order with order ID and payable amount.  User entering an existing order ID will be lead to pay corresponding amount.    

2-Fixed Payment without Order ID   

User will be directly lead to pay a fixed amount that has set by admin. No Order ID will be asked.  
 
3-User defined Payment with Order ID  

User will be asked to enter the amount they wish to pay after entering Order ID.  Also admin can create order with order ID and payable amount.  User entering an existing order ID will be lead to pay corresponding amount.

4-User defined Payment without Order ID  

User will be lead to pay the amount they wish to pay.  
 
Phone Pay works with Twilio and Stripe. You should have working phone number with Twilio and an active stripe account to start phone pay. 


Who we are:
-----------
Phone Pay is developed at Nethram.Nethram is a Silicon Valley based telecommunications and cloud innovator.
 Our mission is to provide the cloud telephony solutions that the big boys use at an affordable price by listening to
 your needs and providing you with what you actually want.

Thank you for using Callblaster, please don't hesitate to write to us at
support@nethram.com. Find more about us at our website www.nethram.com



Screen shots
============
<img src="http://nethram.com/sandbox/phonepay_docs/dashboard.png">  

<img src="http://nethram.com/sandbox/phonepay_docs/log.png">  

<img src="http://nethram.com/sandbox/phonepay_docs/settings.png">  

<img src="http://nethram.com/sandbox/phonepay_docs/help.png">  


