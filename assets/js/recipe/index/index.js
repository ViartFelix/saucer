import $ from "jquery";

$(() => {
	$("[data-filter-trigger]").on("click", (event)=>{
		event.preventDefault()

		$("[data-filter-trigger]").toggleClass("undeployed")
		$("[data-filters]").toggleClass("hidden")
	})
})