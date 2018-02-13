let thumbnail = document.querySelectorAll(".picture");


for (var i = 0; i < thumbnail.length; i++) {
	thumbnail[i].addEventListener("mouseover", () => {
		let hover_bottom = document.querySelector(".hover_bottom");
		let hover_top = document.querySelector(".hover_top");

		hover_bottom.classList.remove("hidden");
		hover_top.classList.remove("hidden");
	},false);

	thumbnail[i].addEventListener("mouseout", () => {
		let hover_bottom = document.querySelector(".hover_bottom");
		let hover_top = document.querySelector(".hover_top");

		hover_bottom.classList.add("hidden");
		hover_top.classList.add("hidden");
	},false);
}