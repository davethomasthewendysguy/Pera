=== Complete Gallery Manager for WordPress ===
Author: RightHere LLC (Rasmus S. Sørensen)
Author URL: http://plugins.righthere.com/complete-gallery-manager/
Tags: WordPress, Isotype, Masonry, Responsive, Infinite Scroll, Gallery, Touch Slider, Fullscreen, Social Media Sharing
Requires at least: 3.1.0
Tested up to: 3.7.1
Stable tag: Version: 3.3.7 rev42213



======== CHANGELOG ========
Version 3.3.7 rev42213 - November 19, 2013
* Bug Fixed: prettyPhoto was broken on some configurations

Version 3.3.6 rev41776 - November 1, 2013
* New Feature: Added best choice (CSS or jQuery according to browser version). 
* New Feature: Choose between new and old media upload select system.
* Bug Fixed: jQuery layout broken in some sites
* Bug Fixed: catID select by start
* Bug Fixed: Sorting by publish date on post
* Bug Fixed: IE8, IE9 and IE10 issues fixed
* Bug Fixed: Not possible to change name of combination filters once created.

Version 3.3.5 rev40891 - October 8, 2013
* Bug Fixed: Some sites loads prettyPhoto twice
* Bug Fixed: Loading error

Version 3.3.4 rev40279 - September 19, 2013
* Bug Fixed: Important Security Fix (upload-images.php)

Version 3.3.3 rev39177 - August 23, 2013
* Bug Fixed: Next and Previous arrow navigation fixed in prettyPhoto
* Bug Fixed: install.php notification error
* New Feature: Added download image option in prettyPhoto
* New Feature: Enable/Disable download image Options Panel

Version 3.3.2 rev39009 - August 20, 2013
* New Feature: Added two new custom capabilities cgm_options and cgm_license. Makes it possible to restrict access to the Options Panel and the License tab. This is useful if you are using the plugin on a clients website.

Version 3.3.1 rev38906 - August 15, 2013
* Bug Fixed: Universal Scroll didn't load the selected no. of images (loaded all images)
* Bug Fixed: Universal Scroll fixed in full screen view and full browser view
* Bug Fixed: Auto load pages and posts
* Bug Fixed: Full screen exit 
* Bug Fixed: Category filtering in Chrome
* New Feature: Manual sort of categories (drag and drop)
* Improvement: Layouts (Masonry, Fit Rows, Straight Down, Masonry Horizontal, Fit Columns)
* Improvement: Performance load time

Version 3.3.0 rev36620 - May 24, 2013
* Update: New loading system, which makes it possible to see image boxes before all images have loaded
* Update: Improved loading time
* Update: Better support for loading images on mobile devices

Version 3.2.8 rev36369 - May 8, 2013
* Bug Fixed: Issue with captions not displaying correctly in some browsers fixed
* Bug Fixed: Size issue with thumbnails fixed

Version: 3.2.7 rev36257 - May 1, 2013
* Bug Fixed: YouTube.com and YouTu.be video URL support in last update didn't work on all configurations. 

Version 3.2.6 rev36235 - April 30, 2013
* New Feature: Added support for basic HTML in description
* Update: PrettyPhoto updated to 3.1.5. Support for jQuery 1.9 (dropped support for IE6)
* Bug Fixed: Pinterest sharing URL error
* Bug Fixed: Captions clickable without delay
* Bug Fixed: Removed PHP warnings
* Bug Fixed: Javascript error on load on certain configurations.
* Bug Fixed: Added support for youtu.be links

Version 3.2.5 rev34942 - March 11, 2013
* New Feature: Update Options Panel with Auto Update

Version 3.2.4 rev34757 - March 7, 2013
* Bug Fixed: Gallery doesn't show when you insert it on a page using https
* Bug Fixed: Not possible to use the "old" format YouTube link

Version 3.2.3 rev34390 - March 1, 2013
* Bug Fixed: Fix problem with "invisible" images on certain themes
* Bug Fixed: Removed PHP warnings

Version 3.2.2 rev33971 - February 13, 2013
* Bug Fixed: Box shadow around overlay icons in TwentyTwelve WordPress theme.

Version 3.2.1 rev33197 - January 26, 2013
* Bug Fixed: Compatibility issue with 3.5.1 fixed.
* Bug Fixed: Apply fix to reset users if they have problems inserting images in gallery (Options Panel)

Version 3.2.0 rev31181 - December 14, 2012
* Update: Compatibility with the new Media Library in WordPress 3.5
* New Feature: Below Show Always Caption
* New Feature: Isotype Gallery and Touch Slider Gallery to Full Screen. Choose between Full Screen or Full Browser setting
* New Feature: Set Gradient on menu
* New Feature: Set Opacity for Gradient on menu
* New Feature: Caption with Title and Description below (always visible)
* New Feature: 5 Hover actions added (Go to Thumbnail, Medium, Large, Full, Custom)
* Bug Fixed: Individually set transparency setting for Overlay Icon didn't work if you inserted two galleries on the same page
* Bug Fixed: Captions Padding settings didn't work properly on Isotype Gallery and Touch Slider Gallery

Version 3.1.1 rev30900 - December 3, 2012
* Bug Fixed: Scroll bar showed vertically and horizontally in some browsers when using category filtering.

Version 3.1.0 rev30025 - November 15, 2012
* New Feature: Touch Slider added. Fully responsive and iPhone, iPad and Smartphone compatible
* New Feature: 3 new captions added (3d box, Title Under, Title + Mouse over description)
* New Feature: Fullscreen option added for Isotype Gallery (Full Browser)

Version 3.0.1 rev29536 - October 24, 2012
* Bug Fixed: Customers installing CGM for the first time had a problem with the menu and could only see the Options Panel. 

Version 3.0.0 rev29469 - October 19, 2012
* New Feature: Insert Gallery into other Galleries. This feature lets you create a Page or Post with multiple galleries. When clicking on a cover picture the gallery will open in a new tab
* New Feature: It is now possible to "View Gallery" immediately after publishing a gallery. This means you don't need to insert the shortcode into the Page or Post in order to view it.
* New Feature: Support for Flickr; Add individual images directly from your Flickr account. Support for Photo Set and Photo Galleries.
* New Feature: Create and Save templates in Complete Gallery Manager. Add new template, remove template, load new template and customize existing template.
* New Feature: Updated available capabilities: cgm_template_save (allows the user to save templates), cgm_template_customize (allows the user to view the customization table).
* New Feature: Old pre-loader icon replaced with new CSS based preloaded. Preloader can be customized. Preloader can also be hidden
* New Feature: Combination Filters. Create groups of filters. Dynamically loading of checked Categories. Hide or Show the Combination Filters.
* New Feature: Added Show or Hide Menu button
* New Feature: Overlay Icons added for each action (prettyPhoto, Link, Pages, Posts, Video, Gallery)
* New Feature: Overlay Icons optimized for retina display (@2x)
* Updated: Preview icons has been updated
* Improvement: Reduced load time for galleries
* Bug Fixed: Gallery no longer crashes if the gallery is open in the wp-admin and at the same time viewed on the public website (auto save created this problem).
* Bug Fixed: IE8 compatibility issues fixed. The Gallery will now load, but please notice that IE8 has limited support for HTML5 and CSS3
* Bug Fixed: Image stretch in "select image" if thumbnails are not 150x150px
* Bug Fixed: Image stretch in "inserted media" if thumbnails are not 150x150px
* Bug Fixed: Issue with Capabilities (would not give Administrator rights when installed and logged in as Administrator). This happened for some users
* Bug Fixed: Problem with captions appear always left and right text alignment
* Bug Fixed: CSS selected menu text shadow could not be removed
* Bug Fixed: Menu border radius could not be removed

Version 2.0.3 rev28734 - August 10, 2012
* Bug Fixed: Width x Height was switched, and caused wrong resizing of thumbnails (according to the size set in Settings > Media). 

Version 2.0.2 rev28693 - August 8, 2012
* Bug Fixed: Problem with IE9 not being able to load the CSS has been fixed
* Bug Fixed: Problem with Pinterest not "pinning" the individual picture, but the entire gallery. This has been fixed so that the individual picture is pinned, and when you click the picture on Pinterest it will take you directly back to the image and show it in prettyPhoto (lightbox).
* Bug Fixed: Shadow effect on menu text can now be removed

Version 2.0.1 rev27876 - July 20, 2012
* Bug Fixed: Gallery Settings not loading when the server is Windows based
* Bug Fixed: CSS name misspelled

Version 2.0.0 rev27524 - July 12, 2012
* Update: The entire core of the plugin has been updated so that it works with the ID number of the media added. This has significantly improved the speed of the gallery. This does unfortunately require you to remove ALL images from your current galleries and reload them. However ALL settings are saved. Simply use the "Remove All Images" button and then add the images again from the media library.
* Update: Cleaned up the Thumbnail sizes. Only showing the four standard sizes from WordPress: Thumbnail, Medium, Large and Full Size
* New Feature: Added new Custom Thumbnail size option
* New Feature: Added Link Overwrite field. This is a local select link action for each type of media, which will overwrite any global settings.
* Update: Removed tag field as its not used by Isotype
* New Feature: Added icon to show type of media (Images, Posts, Pages, Videos)
* New Feature: Available Categories for each media type will only show categories that are selected from the Category Metabox.
* New Feature: Added Remove All Images button to "Selected Images". This makes it possible to quickly remove all inserted media.
* New Feature: Automatically retrieve Title, Description and Permalink when images are selected
* Update: Images are reloaded when the sort type is changed in the pop up window for selecting images to make sure that all data comes in the right flow.
* New Feature: Support for adding Post(s) with attachment image(s)
* New Feature: Select Category and add all Posts with attachment images. Automatically retrieve title, content, link (auto update if post changes). Title link description is locked (auto reload data)
* New Feature: Support for adding Page(s) with attachment image(s)
* New Feature: Select Patent Page with attachment image in order to add all sub-pages. Automatically retrieve title, content, link (auto update if page changes). Title link description is locked (auto reload data)
* New Feature: Support for adding YouTube or Vimeo Videos. Automatically retrieve title and saves preview images to media library (only one time even though you might add the video multiple times)
* New Feature: Support for selecting alternate preview image for video (from Media Library)
* New Feature: Added player button icon to preview image in order to show that it is a Video
* New Feature: Added option to set maximum number of words to captions that will be displayed to make sure Post(s) and Page(s) description data is not too long
* New Feature: Added support for "max word indicator" (More, Read More etc.)
* New Feature: Added 4 new types of captions that will always be visible (doesn't require mouse over action to activate)
* New Feature: Set inside shadow color, offset and blur for menu
* Bug Fixed: You can now click on captions 


Version 1.0.3 rev26366 - June 22, 2012
* Bug Fixed: Facebook like button div fixed.

Version 1.0.2 rev25760 - June 6, 2012
* Bug Fixed: Remove warnings on debug mode (causing image upload and select images to fail)
* Update: Updated Options Panel

Version 1.0.1 rev25421 - May 30, 2012
* New Feature: Added Support for 4 Custom Capabilities:
	cgm_create_gallery
	cgm_upload_images
	cgm_select_images
	cgm_insert_gallery
* Bug Fixed: Animation on click to next size
* Bug Fixed: Universal Scroll load

Version 1.0.0 rev25273 - May 25, 2012
* First release.


======== DESCRIPTION ========
Complete Gallery Manager for WordPress is an exquisite jQuery plugin for creating magical galleries with Pictures, Posts, Pages and Videos. This is an incredible versatile plugin, which lets you create amazing looking galleries very easily. From simple fully responsive galleries or with infinite scroll, with this plugin it is very easy. The galleries support prettyPhoto lightbox with major social sharing icons; Facebook Like, Twitter, Google+ and Pin It. You can also enable captions on each picture in the gallery.

The plugin is ready for internationalization. 

== INSTALLATION ==

1. Upload the 'complete-gallery-manager' folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. In the menu you will find CGM Settings (Complete Gallery Manager Settings)

== FREQUENTLY ASKED QUESTIONS ==
If you have any questions or trouble using this plugin you are welcome to contact us through our profile on Codecanyon (http://codecanyon.net/user/RightHere)

Or visit our HelpDesk at http://support.righthere.com


== SOURCES - CREDITS & LICENSES ==

We have used the following open source projects, graphics, fonts, API's or other files as listed. Thanks to the author for the creative work they made.

1) Isotope Commercial License
   Item # 13620 
   David DeSandro   
   http://isotope.metafizzy.co/

2) prettyPhoto
   http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/

3) Captions
   Licensor's Author Username: DADU
   Licensee: RightHere LLC
   License: One Extended License
   For the item: Captions
   http://codecanyon.net/item/captions/159760
   Item # 159760
   Item Purchase Code: 08e1a444-80a5-4d30-97e4-2258c67f5017