let hover_on_image = function() {
	let thumbnail = document.querySelectorAll(".picture");
	
		for (var i = 0; i < thumbnail.length; i++) {
			thumbnail[i].addEventListener("mouseover", function(){
				let test = this.id.slice(14);
				let hover_bottom = document.querySelector("#hover_bottom" + test);
	
				if (hover_bottom)
					hover_bottom.classList.remove("hidden");
			});
	
			thumbnail[i].addEventListener("mouseout", function(){
				let test = this.id.slice(14);
				let hover_bottom = document.querySelector("#hover_bottom" + test);
	
				if (hover_bottom)
					hover_bottom.classList.add("hidden");
			});
		}
};

hover_on_image();
let observer = new MutationObserver(hover_on_image);
let photomontages_last = document.querySelector('#photomontages_last');
let content = document.querySelector('.content');

if (photomontages_last)
	observer.observe(photomontages_last, {childList: true});
if (content)
	observer.observe(content, {childList: true});