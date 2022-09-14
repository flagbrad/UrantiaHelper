# UrantiaHelper
A MediaWiki parser extension that allows embedding of {{tub:195:9.8}} referenced to ''The Urantia Book'' in WikiText on MediaWiki pages.

This will produce a standard MediaWiki external link to a website where this text can be read in English.

Valid forms of references:
* {{tub:195}} is for the start of Paper 195
* {{tub:195:8}} is the for the start of Paper 195, Section 8
* {{tub:195.8.3} is to go direct to the third paragraph of seciton 8 in Paper 195.
* {{tub:195.8-10} opens section 8 of Paper 195, but allows writing whatever reading range information you'd like.
   * Someday perhaps this could be extended to somehow show ''only'' the range of text indicated.

Installation
------------
* Download this repo and place the files in a directory called UrantiaHelper in your MediaWiki extensions/ folder.
* Add the following code to your LocalSettings.php: **wfLoadExtension( 'EventLogging' );**
* Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

Limitations
-----------
* Not a lot of checking for invalid values.
