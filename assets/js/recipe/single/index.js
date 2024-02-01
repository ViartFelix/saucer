import $ from "jquery"
import "share-buttons"

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
}