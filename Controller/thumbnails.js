let thumbnail = document.querySelectorAll(".picture");


for (var i = 0; i < thumbnail.length; i++) {
	thumbnail[i].addEventListener("mouseover", function(){
        // console.log("#" + this.id + ">.hover_bottom");
        let test = this.id.slice(8);
        // console.log("youhou test : " + test);
        let hover_bottom = document.querySelector("#hover_bottom" + test);
        // console.log("youhou : " + hover_bottom);

		hover_bottom.classList.remove("hidden");
	});

	thumbnail[i].addEventListener("mouseout", function(){
        let test = this.id.slice(8);
        let hover_bottom = document.querySelector("#hover_bottom" + test);

		hover_bottom.classList.add("hidden");
	});
}