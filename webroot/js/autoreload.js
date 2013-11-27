var run = function(time) {
	return $.Deferred(function(dfd) {
		setTimeout(dfd.resolve, time)
	}).promise();
}
run(300).then(function() {
	$('.progress .progress-bar').each(function() {
		var $this = $(this), rate = $this.attr('data-rate'), current = 100;
		var progress = setInterval(function() {
			if (current <= rate) {
				clearInterval(progress);
				location.reload();
			} else {
				current -= 1;
				$this.css('width', (current) + '%');
			}
		}, 250);
	});
});