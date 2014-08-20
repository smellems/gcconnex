/**
 * Phloor Body Background
 * 
 * @package phloor_body_background
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author void <void@13net.at>
 * @copyright 2012 by 13net
 * @link http://phloor.13net.at/
 */

/**
 * Description
 */
Enables custom background settings on your Elgg site. 

This plugin enables Administrators to change Elggs css background 
settings - this includes uploading a background image or changing 
the background color. 

Also your users will be able to upload up to 3 background images
that can be individually placed everywhere on the page.

Only tested with Elggs default theme. This might not work with 
every third party theme - depends on its implementation.
Just give it a try! You can also create you own unique theme very easily
by adapting the css rules to your needs 
(see Matt Becketts "Customize CSS" plugin).

Extends the elgg css view like this:
elgg_extend_view('css/elgg', 'phloor_body_background/css/body_background', 501);

See the file 'phloor_body_background/views/default/phloor_body_background/css/body_background' for the
css thats added.

/**
 * Languages
 */
English
German (cooming soon!)
