Request Membership for closed groups
====================================
This module will enable non members of a closed group to submit an application (justification/reason) to the closed group leader.


Contents
--------
1. Module Dependencies
2. Installation Guide
3. Future Development
4. Use Cases


1. Module Dependencies
----------------------
- required to be after the groups module
- required to be after the group tools module
- tested and implemented on an Elgg v1.8 platform
- tested on Google Chrome, Internet Explorer 7+ and Mozilla Firefox (Javascript enabled/disabled)


2. Installation Guide
----------------------
- standard installation of module, no further setup requires


3. Future Development
---------------------
- patches/maintenance if required


4. Use Cases
-------------
- Covers the following cases
	+ javascript enabled/disabled
	+ prompts user upon requesting to join a closed group
	+ allows group owner to view application sent in from a user
	+ application will be removed from database when group owner approves/disapprove user
- Does not for the following cases:
	+ group owner receives an email notification for each application that gets sent in
	+ validating user credentials (no connection to GEDS)
	+ allow user to take back application
