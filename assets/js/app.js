import * as Iconify from "@iconify/iconify";
import $ from "jquery"
import gsap from "gsap"

$(()=>{
	let headerHeight = $("header#main-header").height()
	let screenHeight = screen.height;

	gsap.to(".container-translate", {
		y: (screenHeight.toString()) * 0.5,
		duration: 0,
		opacity: 0,
	})

	gsap.to(".container-translate", {
		y: 0.75 * headerHeight,
		duration: 1.25,
		opacity: 1,
		ease: "power3.out"
	})
})
