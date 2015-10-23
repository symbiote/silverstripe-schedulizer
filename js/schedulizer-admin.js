;(function ($) {
	$(function () {
		
		$('#ScheduleTestField button').entwine({
			onclick: function () {
				var input = $(this).parent().find('input[type=text]');
				var testDate = input.val();
				if (testDate) {
					var matches = location.href.match(/ConfiguredSchedule\/item\/(\d+)/);
					if (matches.length == 2) {
						$.get('admin/schedulizer/ConfiguredSchedule/testschedule', {ID: matches[1], date: testDate}).done(function (data) {
							input.val(data);
						});
					}
				}
			}
		});
	});
})(jQuery);