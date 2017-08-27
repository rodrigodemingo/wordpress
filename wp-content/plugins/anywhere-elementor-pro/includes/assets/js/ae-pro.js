jQuery(document).on('elementor/render/cf-video',function(e,id,a_ratio){
    container_element = '.elementor-element-'+ id;
    iframe_element = '.elementor-element-' + id + ' .cf-type-video iframe';
    iframe_width = jQuery(iframe_element).width();

    // get aspect ratio

    aspectRatio = a_ratio;
    if(aspectRatio == 169){
        ar = [16,9];
    }else if(aspectRatio == 43){
        ar = [4,3]
    }else{
        ar = [3,2]
    }


    iframe_height = iframe_width * (ar[1]/ar[0]);

    jQuery(iframe_element).height(iframe_height);
});


jQuery(document).on('click','.ae-pagination-wrapper a',function(){

    var page_num = 1
    var wrapper = jQuery(this).closest('.ae-post-widget-wrapper');
    var ae_post_overlay = wrapper.siblings('.ae-post-overlay');

    var wid = wrapper.data('wid');
    console.log(wrapper.parents('.ae-data'));
    if(wrapper.parents('.ae_data').length > 0){ console.log('wrapper found');
        var pid = wrapper.parents('.ae_data').attr('data-aetid');
    }else{ console.log('wrapper not found');
        var pid = wrapper.data('pid');
    }

    var url = jQuery(this).attr('href');
    if(typeof url.split("page/")[1] != 'undefined'){
        page_num = url.split("page/")[1].split('/')[0];
    }
    ae_post_overlay.show();
    var data = {
        'pid' : pid,
        'wid' : wid,
        'page_num' : page_num,
        action: 'ae_post_data',
        fetch_mode: 'paged'
    }

    jQuery.ajax({
        url: aepro.ajaxurl,
        dataType: 'json',
        data: data,
        method: 'POST',
        success: function (res) {
            wrapper.html(res.data);
            wrapper.find('.ae-featured-bg-yes').each(function(){
                img = jQuery(this).attr('data-ae-bg');
                jQuery(this).css('background-image','url(' + img + ')');
            });
            ae_post_overlay.hide();
        }
    });

    return false;
});



