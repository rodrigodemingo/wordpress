jQuery(document).ready(function($){
    $("#butterbean-manager-ae_pro .butterbean-control").hide();

    initialLoad();

    jQuery(document).on('change',
            '[name="butterbean_ae_pro_setting_ae_apply_global"], ' +
            '[name="butterbean_ae_pro_setting_ae_render_mode"], ' +
            '#butterbean-control-ae_hook_apply_on input, ' +
            '[name="butterbean_ae_pro_setting_ae_usage"]',
        function(){
            $("#butterbean-manager-ae_pro .butterbean-control").hide();
            initialLoad();
    });


    function initialLoad(){
        showfield('butterbean_ae_pro_setting_ae_render_mode');
        var render_mode = $('[name="butterbean_ae_pro_setting_ae_render_mode"]').val();
        console.log(render_mode);
        switch(render_mode){
            case 'post_type_archive_template'   :    pt_archive();
                                                    break;

            case 'post_template'                :  post_template();
                                                   break;

            case 'archive_template'             : archive_template();
                                                  break;

            case 'block_layout'                 : block_layout();
                                                  break;

            case 'normal'                       :  normal();
                                                    break;

            case '404'                          : _404();
                                                  break;
        }
    }

    function showfield(field){
        $('[name="' + field +'"]').closest('.butterbean-control').show();
    }

    function _404(){
        showfield('butterbean_ae_pro_setting_ae_enable_canvas');
    }

    function archive_template(){
        showfield('butterbean_ae_pro_setting_ae_preview_post_ID');
        showfield('butterbean_ae_pro_setting_ae_apply_global');
        $("#butterbean-control-ae_rule_taxonomy").show();
        showfield('butterbean_ae_pro_setting_ae_full_override');
        showfield('butterbean_ae_pro_setting_ae_enable_canvas');

    }

    function block_layout(){
        showfield('butterbean_ae_pro_setting_ae_preview_post_ID');

    }


    function normal(){
        showfield('butterbean_ae_pro_setting_ae_usage');

        usage_area = $('[name="butterbean_ae_pro_setting_ae_usage"]').val();
        console.log(usage_area);
        if(usage_area == 'custom'){
            $("#butterbean-control-ae_custom_usage_area").show();
        }

        if(usage_area != ''){
            jQuery("#butterbean-control-ae_apply_global").show();
            auto_apply = $('[name="butterbean_ae_pro_setting_ae_apply_global"]').is(":checked");

            if(!auto_apply){
                // auto apply not set.. reveal advanced rules
                $("#butterbean-control-ae_hook_apply_on").show();
                console.log("page type reveal");
                page_types = $("#butterbean-control-ae_hook_apply_on input:checked").map(function () {return this.value;}).get();

                // show post options in case of single post
                console.log(page_types);
                console.log('index of ' + page_types.indexOf('single'));
                if(page_types.indexOf('single') >= 0){
                    jQuery("#butterbean-control-ae_hook_post_types").show();
                    jQuery("#butterbean-control-ae_hook_posts_selected").show();
                    jQuery("#butterbean-control-ae_hook_posts_excluded").show();
                }

                if(page_types.indexOf('archive') >= 0){
                    jQuery("#butterbean-control-ae_hook_taxonomies").show();
                    jQuery("#butterbean-control-ae_hook_terms_selected").show();
                    jQuery("#butterbean-control-ae_hook_terms_excluded").show();
                }
            }



        }
    }

    function post_template(){
        showfield('butterbean_ae_pro_setting_ae_preview_post_ID');
        showfield('butterbean_ae_pro_setting_ae_apply_global');
        showfield('butterbean_ae_pro_setting_ae_rule_post_type');
    }

    function pt_archive(){
        showfield('butterbean_ae_pro_setting_ae_preview_post_ID');
        showfield('butterbean_ae_pro_setting_ae_rule_post_type_archive');
        showfield('butterbean_ae_pro_setting_ae_full_override');
        showfield('butterbean_ae_pro_setting_ae_enable_canvas');
    }

});

