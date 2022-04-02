document.querySelectorAll(".submit-form").forEach(
	element => element.addEventListener('click', async function(){
	
		let formData = {};
		let headers = {};
	
		const formId = this.dataset.form;
	
		let form = document.getElementById(formId);

		let id = this.dataset.id;
		let send = this.dataset.send;
	
		if(typeof this.dataset.id !== 'undefined'){
			formData = new FormData();
			formData.append('id', id);
		
			headers = {
				'X-CSRF-TOKEN': document.querySelector("meta[name=csrf-token]").getAttribute("content"),
			};
		}else{
			formData = new FormData(form);
		}	
	
		const response = await fetch(send, {
			method: 'POST',
			headers: headers,
			body: formData
		})
		.then(response => response.json())
		.then(result => {
	
			if(result.data != undefined){	
				for (const [key, value] of Object.entries(result.data)) {
					$(`.${key}`).html(value);

					if(key == 'like')
					{
						
					}
				}
			}

			if(typeof result.errors !== 'undefined'){
				let message = '';
				for (const [key, value] of Object.entries(result.errors)) {
					message = value;
				};		

				result.message = message;
			}

			if(typeof result.message !== 'undefined' && result.message !== null){
				
				$('body')
				  .toast({
				    displayTime: 5000,
				    message: result.message,
					class: typeof result.color != undefined ? result.color : ''
				  })
				;

				if(this.tagName == 'BUTTON'){
					this.classList.remove('loading','disabled');
				}
			}		
			

			if(typeof result.redirect != undefined)
				if(result.redirect == 1)
			  		location.href = result.url
			
		});
	})
);