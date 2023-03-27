	//Cadastro de Empresas
	function cadastrar_empresas() {
		$('#form_company')[0].reset();
		$("[name='acao_company']").val('cadastrar');
		$('#modal_company').modal('show');
	}
	//Edição de Empresas
	function editar_empresa(id) {
	
		$.post('', {

			acao_company: 'editar',
			id: id
		}, function(data) {
			 (data)
			let dados = JSON.parse(data);
			$("[name='id']").val(dados.id);
			$("[name='stur_cod']").val(dados.stur_cod);
			$('[name="name"]').val(dados.name);
			$('[name="email"]').val(dados.email);
			$('[name="cnpj"]').val(dados.cnpj);
			$('[name="address1"]').val(dados.address1);
			$('[name="address2"]').val(dados.address2);
			$('[name="city"]').val(dados.city);
			$('[name="uf"]').val(dados.uf);
			$('[name="phone1"]').val(dados.phone1);
			$('[name="phone2"]').val(dados.phone2);
			$('[name="contact_name"]').val(dados.contact_name);
			$('[name="tipo"]').val(dados.tipo);
			
			$("[name='acao_company']").val('atualizar');
			$('#modal_company').modal('show');
		});
	}
	//Exclusão de Empresas
	function excluir_empresa(id) {
		let c = confirm("Deseja excluir?")
		if (c == true) {
			$.post('', {
				acao_company: 'excluir',
				id: id
			}, function(data) {
				 (data);
				window.location.reload();
			});
		}
	}

		//Cadastro de Sistemas
		function cadastrar_sistemas() {
			$('#form_system')[0].reset();
			$("[name='acao_system']").val('cadastrar');
			$('#modal_system').modal('show');
		}
		//Edição de Sistemas
		function editar_sistema(id) {
			$.post('', {
				acao_system: 'editar',
				id: id
			}, function(data) {

				let dados = JSON.parse(data);
				
				$("[name='id']").val(dados.id);
				$("[name='name']").val(dados.name);
				
				$("[name='acao_system']").val('atualizar');
				$('#modal_system').modal('show');
			});
		}
		//Exclusão de Sistemas
		function excluir_sistema(id) {
			let c = confirm("Deseja excluir?")
			if (c == true) {
				$.post('', {
					acao_system: 'excluir',
					id: id
				}, function(data) {
					window.location.reload();
				});
			}
		}

		//Cadastro de Órgãos
		function cadastrar_orgaos() {
			$('#form_agencies')[0].reset();
			$("[name='acao_agencies']").val('cadastrar');
			$('#modal_agencies').modal('show');
		}
		//Edição de Órgãos
		function editar_orgaos(id) {
			$.post('', {
				acao_agencies: 'editar',
				id: id
			}, function(data) {

				let dados = JSON.parse(data);
				
				$("[name='id']").val(dados.id);
				$("[name='name']").val(dados.name);
				
				$("[name='acao_agencies']").val('atualizar');
				$('#modal_agencies').modal('show');
			});
		}
		//Exclusão de Orgaos
		function excluir_orgaos(id) {

			let c = confirm("Deseja excluir?")
			if (c == true) {
				$.post('', {
					acao_agencies: 'excluir',
					id: id
				}, function(data) {

					window.location.reload();
				});
			}
		}

		//Cadastro de Produtos
		function cadastrar_produtos() {
			$('#form_produtos')[0].reset();
			$("[name='acao_produtos']").val('cadastrar');
			$('#modal_produtos').modal('show');
		}
		//Edição de Produtos
		function editar_produtos(id) {
			 ('oi');
			$.post('', {
				acao_produtos: 'editar',
				id: id
			}, function(data) {

				let dados = JSON.parse(data);
				
				$("[name='id']").val(dados.id);
				$("[name='name']").val(dados.name);
				
				$("[name='acao_produtos']").val('atualizar');
				$('#modal_produtos').modal('show');
			});
		}
		//Exclusão de Produtos
		function excluir_produtos(id) {

			let c = confirm("Deseja excluir?")
			if (c == true) {
				$.post('', {
					acao_produtos: 'excluir',
					id: id
				}, function(data) {
					window.location.reload();
				});
			}
		}

		//Cadastro de Clientes
		function cadastrar_clientes() {
			$('#form_clientes')[0].reset();
			$("[name='acao_clientes']").val('cadastrar');
			$('#modal_clientes').modal('show');
		}
		//Edição de Clientes
		function editar_clientes(id) {
			$.post('', {
				acao_clientes: 'editar',
				id: id
			}, function(data) {

				let dados = JSON.parse(data);
				
				$("[name='id']").val(dados.id);
				$("[name='stur_cod']").val(dados.stur_cod);
				$("[name='nome_cliente']").val(dados.nome_cliente);
				$("[name='razao_social']").val(dados.razao_social);
				$("[name='cnpj']").val(dados.cnpj);
				$("[name='address']").val(dados.address);
				$("[name='neighbour']").val(dados.neighbour);
				$("[name='cep']").val(dados.cep);
				$("[name='phone']").val(dados.phone);
				$("[name='state']").val(dados.state);
				$("[name='city']").val(dados.city_name);
				$("[name='email']").val(dados.email);
				$("[name='empresa']").val(dados.empresa);
				
				$("[name='acao_clientes']").val('atualizar');
				$('#modal_clientes').modal('show');
			});
		}
		//Exclusão de Clientes
		function excluir_clientes(id) {

			let c = confirm("Deseja excluir?")
			if (c == true) {
				$.post('', {
					acao_clientes: 'excluir',
					id: id
				}, function(data) {
					window.location.reload();
				});
			}
		}

		$(document).ready(function() {
			$('.valor').mask('00000000000.00', {
				reverse: true
			});
		});

	function fetchCities(){
		let state = $("[name='state']").val();

		$.post('', {
			state: state,
			acao_clientes: 'fetch_cities'
		}, function(data){
			$('#city').html(data);
		})
	}




