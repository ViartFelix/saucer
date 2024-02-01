import $ from "jquery"

$(()=>{
	new Main()
})

class Main
{

	constructor() {
		this.hydrate()
	}

	hydrate()
	{
		$(".add_item_link").on("click", this.addFormToCollection)
		$(".thumbnail-input").on("click", this.addThumbnail)
		$("#thumbnail-real-input input").on("change", this.handleUploadedFile)
		$("#thumbnail-real-input input").on("click", function(event) { event.stopPropagation() })
	}

	addFormToCollection(event)
	{
		//Prise de la template
		const collectionHolder = document.querySelector('.' + event.currentTarget.dataset.collectionHolderClass);

		//item créé
		const item = document.createElement('div');

		item.innerHTML = collectionHolder
			.dataset
			.prototype
			.replace(
				/__name__/g,
				collectionHolder.dataset.index
			);

		collectionHolder.appendChild(item);

		collectionHolder.dataset.index++;
	}

	addThumbnail(event)
	{
		event.stopPropagation()
		$("#thumbnail-real-input input").click()
	}

	handleUploadedFile(e)
	{
		let file = e.target.files[0];

		if (file) {
			let reader = new FileReader();
			reader.onload = function (event) {
				$("#thumbnail-preview")
					.attr("src", event.target.result);
			};
			reader.readAsDataURL(file);
		}
	}
}