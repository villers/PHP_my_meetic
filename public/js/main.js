$(document).ready(function(){
	var form = $('form#search');
	var min = form.find('#age');
	var max = form.find('#age2');
	var sexe = form.find('select[name="ssexe"]');
	var pays = form.find('#pays');
	var region = form.find('#region');
	var departement = form.find('#departement');
	var ville = form.find('#ville');

	min.on('change',function(){
		searchForm();
	});

	max.on('change',function(){
		searchForm();
	});

	sexe.on('change',function(){
		searchForm();
	});

	pays.on('change',function(){
		searchForm();
	});

	region.on('change',function(){
		searchForm();
	});

	departement.on('change',function(){
		searchForm();
	});

	ville.on('change',function(){
		searchForm();
	});

	$('#submit').on('click',function(e){
		e.preventDefault();
		searchForm();
	});

	var searchForm = function(){
		$('.seachlist').each(function(index, value){
			$(this).hide();

			$(this).filter(function(){ // age
				var age = parseInt($(this).find('.age').text());
				return (age <= parseInt(max.val()) && age >= parseInt(min.val()));
			})
			.filter(function(){ // sexe
				var sex = $(this).find('.sexe').text();
				return (sex === sexe.val() || 'T' == sexe.val());
			})
			.filter(function(){
				var paysl = $(this).find('.pays').text();
				return (paysl.indexOfInsensitive(pays.val()) != -1);
			})
			.filter(function(){
				var regionl = $(this).find('.region').text();
				return (regionl.indexOfInsensitive(region.val()) != -1);
			})
			.filter(function(){
				var departementl = $(this).find('.departement').text();
				return (departementl.indexOfInsensitive(departement.val()) != -1);
			})
			.filter(function(){
				var villel = $(this).find('.ville').text();
				var multiVille = $.map(ville.val().split(","), $.trim);
				if(villel.indexOfInsensitive(multiVille[0]) != -1)
					return true;
				else if(multiVille[1] && villel.indexOfInsensitive(multiVille[1]) != -1)
					return true;
				else if(multiVille[2] && villel.indexOfInsensitive(multiVille[2]) != -1)
					return true;
				else if(multiVille[3] && villel.indexOfInsensitive(multiVille[3]) != -1)
					return true;
				else if(multiVille[4] && villel.indexOfInsensitive(multiVille[4]) != -1)
					return true;
				else
					return false;
			})
			.show();
		});
	};
});

String.prototype.indexOfInsensitive = function (s, b) {
	return this.toLowerCase().indexOf(s.toLowerCase(), b);
}