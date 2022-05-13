var clipboard = new ClipboardJS('.btn');
clipboard.on('success', function (e) {
	console.log("ok");
	$("#gracias").show();
});

//var d = new Date('2022-09-10 12:00:00'); 
var fullDate = "2022-09-10 13:00:00";
var d = new Date(fullDate);

if(Number.isNaN(d.getMonth())) {
	let arr = fullDate.split(/[- :]/);
	d = new Date(arr[0], arr[1]-1, arr[2], arr[3], arr[4], arr[5]);
  }
// default example
simplyCountdown('.simply-countdown-one', {
	year: d.getFullYear(),
	month: d.getMonth() + 1,
	day: d.getDate(),
	hours: d.getHours(),
	minutes: d.getMinutes(),
	seconds: d.getSeconds(),
});


$(document).ready(function () {

	
	jQuery("#animated-thumbnails-gallery")
		.justifiedGallery({
			captions: false,
			lastRow: "hide",
			rowHeight: 180,
			margins: 5
		})
		.on("jg.complete", function () {
			window.lightGallery(
				document.getElementById("animated-thumbnails-gallery"), {
					autoplay: true,
					autoplayControls :true,
					thumbnail: false,
					speed: 500,
					//mode: 'fade',
					pager: false,
					galleryId: "memorias",
					download: false,
					allowMediaOverlap: true,
					controls: true,
					showCloseIcon: true,
					mobileSettings: {
						download: false,
						rotate: false
					},
				}
			)
		})
		.on("lgBeforeOpen", function () {
			document.getElementById('myAudio').play();
		})
		.on("lgBeforeClose", function () {
			document.getElementById('myAudio').pause();
		});


});