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
			let message = null;

			console.log(result.data)
			if(result.data != undefined){	
				for (const [key, value] of Object.entries(result.data)) {
					$(`.${key}`).html(value);

					if(key == 'like')
					{
						
					}
				}
			}
				

			
			if(message != null)
			{
				$('body')
				  .toast({
				    title: '',
				    message: 'See, how long i will last',
				    //showProgress: 'bottom'
				  })
				;
			}
			
			

			if(typeof result.redirect != undefined)
				if(result.redirect == 1)
			  		location.href = result.url
			
		});
	})
);