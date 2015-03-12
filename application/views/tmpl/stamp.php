<script id='stamp_wrapper' type='text/x-jquery-tmpl'>
<div class="col-md-2 col-masonry" style="position: absolute; left: 0px; top: 0px;">
  <div class="product-thumb">
    <header class="product-header">
      <img title="Hot mixer" alt="Image Alternative text" src="${stamp_photo}">
    </header>
    <div class="product-inner">
      <h5 class="product-title">
        <a href="${base_url()}stampDetail/viewDetail/${t_id}" target="_blank">${t_name}</a>
      </h5>
      <div class="product-desciption">
        by <b><a href="${base_url()}user/${t_uid}" id="" class="unameStamp" uid="${t_uid}">${uname}</a></b>
      </div>
      <div class="product-meta">
        <span class="product-time">
          <i class="fa fa-clock-o">
          </i>
         ${t_modified_date}
        </span>
	{{if t_tags.length > 0}}
        <ul class="product-price-list">
	{{each t_tags}}
		<li>
		    <span class="product-price">
		      <a href="${base_url()}tags/${$value}" class="tag" title="models">${$value}</a>
		    </span>
		  </li>
	{{/each}}          
        </ul>
	{{/if}}
      </div>
      {{if t_ownercountry != ""}}
      <p class="product-location">
        <i class="fa fa-map-marker">
        </i>
        ${t_ownercountry}
      </p>
      {{/if}}
    </div>
    {{if ismy == true}}
	<div id="divDelStamp" class="trick-card-tags clearfix">
		<button class="btn btn-primary pull-right delStamp" id="delStamp_${t_id}"><i class="fa fa-trash-o"></i></button>
		<button class="btn btn-primary pull-left" onclick="location.href=$(this).attr('href')" href="${base_url()}profile/addstamp/${t_id}"><i class="fa fa-edit"></i></button>
	</div>
    {{/if}}
  </div>
</div>
</script>