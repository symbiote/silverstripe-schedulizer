<?php
/**
 * Description of SchedulizerModelAdmin
 *
 * @author Stephen McMahon <stephen@silverstripe.com.au>
 */
class SchedulizerModelAdmin extends ModelAdmin {
	public static $menu_title = 'Schedulizer';
	public static $url_segment = 'schedulizer';

	public static $managed_models = array(
		'ConfiguredSchedule'
	);

	public static $allowed_actions = array(
	);
}
