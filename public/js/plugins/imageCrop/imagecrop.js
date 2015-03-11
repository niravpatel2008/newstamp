(function(window, $){
  var imageCrop = function($image, options){
      this.$image = $($image);
      this.options = options;
	  this.$outline = "";
    };

  imageCrop.prototype = {
    defaults: {
     minSelect : [50, 50],
	 outlines : [],
     count:0
    },
    init: function() {
			this.config = $.extend({}, this.defaults, this.options);
			var $holder = $('<div id="img-container" />')
					.css({
						position : 'relative'
					})
					.width(this.$image.width())
					.height(this.$image.height());

			this.$image.wrap($holder)
				.css({
					position : 'absolute'
				});
			$this = this;
			this.$image.mousedown(function(event){$this.setSelection($this,event)});

			if (typeof(this.config.selections) != "undefined")
			{
				this.setAllSelection(this);
			}

			$("#img-container").delegate('.stamp-save',"click",function(event){$this.saveStamp($this,event)});
			$("#img-container").delegate('.stamp-remove',"click",function(event){$this.removeStamp($this,event)});
			return this;
    },
	getElementOffset: function(object) {
		var offset = $(object).offset();

		return [offset.left, offset.top];
	},
	getMousePosition: function(event) {
		var imageOffset = this.getElementOffset(this.$image);

		var x = event.pageX - imageOffset[0],
			y = event.pageY - imageOffset[1];

		x = (x < 0) ? 0 : (x > this.$image.width()) ? this.$image.width() : x;
		y = (y < 0) ? 0 : (y > this.$image.height()) ? this.$image.height() : y;

		return [x, y];
	},
	addNewSelection: function(v) {
		
		if(v)
		{
			t_id = v.id;
			st_name = v.st_name;
			st_year = v.st_year;
			st_price = v.st_price;
			st_country = v.st_country;
			st_bio = v.st_bio;
			v = JSON.parse(v.area);
		}

		$this = this;
		var id = this.config.count++;
		$(".image-crop-outline").css({borderColor:'#ffffff'});
		this.$outline = $('<div class="image-crop-outline" id="outline'+"-"+id+'"/>')
			.css({
				opacity : this.config.outlineOpacity,
				position : 'absolute',
				borderColor:'#99C8FF',
				width: (v)?v.w:this.config.minSelect[0],
				height: (v)?v.h:this.config.minSelect[1]
			})
			.insertAfter(this.$image);

		if(typeof(t_id) != 'undefined' && t_id != "")
		{	
			this.$outline.data("t_id",t_id);
			this.$outline.data("country",st_country);
			this.$outline.data("name",st_name);
			this.$outline.data("price",st_price);
			this.$outline.data("year",st_year);
			this.$outline.data("bio",st_bio);
		}

		this.config.outlines[id]=this.$outline;
		//console.log($image);
		this.$outline.resizable({containment:"#img-container"}).draggable({containment:"#img-container"});
		this.$outline.on('click',function(){
			var cid = $this.$outline.attr('id').replace('outline-',"");
			var nid = $(this).attr('id').replace('outline-',"");
			if (cid != nid)				
			{
				$(".image-crop-outline").css({borderColor:'#ffffff'});
				$this.$outline = $this.config.outlines[nid];
				$this.$outline.css({borderColor:'#99C8FF'});
			}
			var isVisible = $this.$outline.next('div.popover:visible').length;
			if (!isVisible)
			{	
				$($this.$outline).popover('show');
				$obj = $this.$outline;
				CountryData = (typeof($($obj).data('country')) != 'undefined')?$($obj).data('country'):"";
				NameData = (typeof($($obj).data('name')) != 'undefined')?$($obj).data('name'):"";
				PriceData = (typeof($($obj).data('price')) != 'undefined')?$($obj).data('price'):"";
				YearData = (typeof($($obj).data('year')) != 'undefined')?$($obj).data('year'):"";
				BioData = (typeof($($obj).data('bio')) != 'undefined')?$($obj).data('bio'):"";

				popOverForm = $obj.next('div.popover:visible')
				$(popOverForm).find(".st_country").val(CountryData);
				$(popOverForm).find(".st_name").val(NameData);
				$(popOverForm).find(".st_price").val(PriceData);
				$(popOverForm).find(".st_year").val(YearData);
				$(popOverForm).find(".st_bio").val(BioData);
				
			}
		});
		
		$this.popOverInit($this.$outline);
		if (v && v.x)
		{
			$this.$outline.css({
				cursor : 'all-scroll',
				display : 'block',
				left : v.x,
				top : v.y
			})
		}
	},
	setSelection: function($this,event) {
		$this.addNewSelection();
		event.preventDefault();
		event.stopPropagation();

		selectionOrigin = $this.getMousePosition(event);
		$this.$outline.css({
				cursor : 'all-scroll',
				display : 'block',
				left : selectionOrigin[0],
				top : selectionOrigin[1]
			})
	},
	getSelection: function() {
		var $pos = [];
		$.each(this.config.outlines,function(e,v){
			if (typeof(v) != "undefined")
			{
				var tleft = parseInt($(v).css('left'));
				var ttop = parseInt($(v).css('top'));
				var twidth = parseInt($(v).width());
				var theight = parseInt($(v).height());

				h = $('#albumImg').height();
				w = $('#albumImg').width();
				iactualHeight = $('#albumImg').data('iheight');
				iactualWidth = $('#albumImg').data('iwidth');
				if ((h != iactualHeight) || (w != iactualWidth))
				{
					wp = (100*tleft)/w;
					hp = (100*ttop)/h;
					tleft =  iactualWidth*wp/100;
					ttop =  iactualHeight*hp/100;

					wp = (100*twidth)/w;
					hp = (100*theight)/h;
					twidth = iactualWidth*wp/100;
					theight = iactualHeight*hp/100;
				}
				console.log("top %s,left %s",tleft,ttop);
				$pos.push({x:tleft ,
						   y:ttop ,
						   w:twidth+4 ,
					       h:theight+4, 
						   t_id:$(v).data('t_id') ,
						   st_country:$(v).data('country') ,
						   st_name:$(v).data('name') ,
						   st_price:$(v).data('price') ,
						   st_year:$(v).data('year') ,
						   st_bio:$(v).data('bio') });
			}
		})
		return $pos;
	},
	setAllSelection: function() {
		$this = this;
		$(this.config.selections[0]).each(function(e,v){
			var area = JSON.parse(v.area);
			iactualHeight = $('#albumImg').data('iheight');
			iactualWidth = $('#albumImg').data('iwidth');

			area.y = ((100*area.y)/iactualHeight) + "%";
			area.x = ((100*area.x)/iactualWidth) + "%";

			area.w = ((100*area.w)/iactualWidth) + "%";
			area.h = ((100*area.h)/iactualHeight) + "%";
			v.area = JSON.stringify(area);
			console.log(area);
			$this.addNewSelection(v);
		});
	},
	popOverInit: function($obj) {
		nid = $($obj).attr('id').replace('outline-',"");
		tplHtml = this.popOverHtml(nid,$obj);

		id = "#"+$obj.attr('id');
		tplTitle = "<div class='clearfix'>Stamp Info: <a href='javascript:void(0);' class='pull-right fa fa-times-circle' onclick='$(\""+id+"\").popover(\"hide\");' title='delete'></a><div>";
		options = {html:true,placement:"top",trigger:"manual",selector:false,title:tplTitle,content:tplHtml};
		//console.log($obj);
		$($obj).popover(options);
	},
	popOverHtml: function(nid,$obj){
		CountryData = (typeof($($obj).data('country')) != 'undefined')?$($obj).data('country'):"";
		NameData = (typeof($($obj).data('name')) != 'undefined')?$($obj).data('name'):"";
		PriceData = (typeof($($obj).data('price')) != 'undefined')?$($obj).data('price'):"";
		YearData = (typeof($($obj).data('year')) != 'undefined')?$($obj).data('year'):"";
		BioData = (typeof($($obj).data('bio')) != 'undefined')?$($obj).data('bio'):"";
		
		Name = '<div class="form-group">';
		Name += '<input class="form-control st_name" type="text" title="Name" value="'+NameData+'" name="al_country" placeholder="Name">';
		Name += '</div>';

		Price = '<div class="form-group">';
		Price += '<input class="form-control st_price" type="text" title="Price" value="'+PriceData+'" name="al_country" placeholder="Price">';
		Price += '</div>';

		Year = '<div class="form-group">';
		Year += '<input class="form-control st_year" type="text" title="Year" value="'+YearData+'" name="al_country" placeholder="Year">';
		Year += '</div>';

		Country = '<div class="form-group">';
		Country += '<input class="form-control st_country" type="text" title="Country" value="'+CountryData+'" name="al_country" placeholder="Country">';
		Country += '</div>';

		Bio = '<div class="form-group">';
		Bio += '<textbox class="form-control st_bio" type="text" title="Bio" name="al_country" placeholder="Bio">'+BioData+'</textbox>';
		Bio += '</div>';

		SubmitBtn = "<div class='form-group clearfix'>";
		SubmitBtn += "<button class='btn btn-primary pull-left stamp-save' data-nid='"+nid+"'><i class=' fa fa-save'></i></button>";
		SubmitBtn += "<button class='btn btn-primary pull-right stamp-remove' data-nid='"+nid+"'><i class=' fa fa-trash-o'></i></button>";
		SubmitBtn += '</div>';

		html = "<div class='col-md-12'>";
		html += Name;
		html += Price;
		html += Year;
		html += Country;
		html += Bio;
		html += SubmitBtn;
		html += "</div>";

		return html;
	},
	removeStamp: function($this,event)
	{
		nid = $(event.target).data('nid');
		$obj = $this.config.outlines[nid];
		
		var t_id = $($obj).data('t_id');
		if (typeof(t_id) != "undefined" && t_id != "")
		{
			$.ajax({
				type: 'post',
				url: admin_path()+'stamp/delete',
				data: 'id='+t_id,
				success: function (data) {
					if (data == "success") {
						$("#flash_msg").html(success_msg_box ('stamp deleted successfully.'));
					}else{
						$("#flash_msg").html(error_msg_box ('An error occurred while processing.'));
					}
				}
			});

		}			
		delete $this.config.outlines[nid];
		$($obj).popover('hide');
		$($obj).remove();
	},
	saveStamp: function($this,event){
		nid = $(event.target).data('nid');
		$obj = $this.config.outlines[nid];
		popOverForm = $obj.next('div.popover:visible')
		$obj.data("country",$(popOverForm).find(".st_country").val());
		$obj.data("name",$(popOverForm).find(".st_name").val());
		$obj.data("price",$(popOverForm).find(".st_price").val());
		$obj.data("year",$(popOverForm).find(".st_year").val());
		$obj.data("bio",$(popOverForm).find(".st_bio").val());
		$($obj).popover('hide');
	}
	 
  }

  imageCrop.defaults = imageCrop.prototype.defaults;

  $.fn.imageCrop = function(options) {
	return this.each(function() {
			var currentObject = this,
			image = new Image();
			image.onload = function() {
				img_real_width = this.width;
			    img_real_height = this.height;
			   $(currentObject).data("iwidth",img_real_width);
			   $(currentObject).data("iheight",img_real_height);
				currentObject.crop = new imageCrop(currentObject, options).init();
			};
			image.src = currentObject.src;
		});
	  };

  window.imageCrop = imageCrop;
})(window, jQuery);