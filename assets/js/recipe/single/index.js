import $ from "jquery"
import Elements from "./elements";

$(()=>{
	//new Main()
	new a()
})

class a
{
	constructor() {
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

class Main
{

	elements;
	lastID=0;

	constructor() {
		this.elements = new Elements();
		this.hydrate()
	}

	hydrate()
	{
		this.elements.addBtn.on("click", (event)=>{
			event.preventDefault()
			this.addInstruction()
		})
	}

	addInstruction()
	{

		this.elements.addTem
			.clone()
			.find("textarea")
			.attr("name", "form[instructions]["+this.getLastID()+"]")
			.parent()
			.appendTo("#instructions")

		this.incrementLastID();
	}


	getLastID()
	{
		this.lastID = parseInt($("#__last-ID__").html()) ?? 0
		return this.lastID;
	}

	incrementLastID()
	{
		this.lastID++;
		$("#__last-ID__").html(this.lastID);
	}

}

/**
 * <div class="hidden" style="display: none" id="add-instruction">
 * 			{{ form_row(form.instructions.vars.prototype) }}
 * 		</div>
 */