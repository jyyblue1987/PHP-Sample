<?php
/* @var $this AdminController */
/* @var $model Admin */
/* @var $form CActiveForm */

/*
$urlPath = Yii::app()->homeUrl . '?r=admin/admin';
$parts = parse_url($returnUrl);
$query = array();
parse_str($parts['query'], $query);
$post_data = json_encode($query);
$returnAction = 'requestUrlWithData("' . $urlPath . '",' . $post_data . ', "POST" );';
*/

?>

<div class="mainbox-body">
    <div class="cm-tabs-content">
        <form name="profile_form" action="" method="post" class="cm-form-highlight">
            <div id="content_general">
                <fieldset>
                    <h2 class="subheader">
                        Push information
                    </h2>
                    <div class="form-field hidden">
						<label for="msg_id" class="cm-required">Broadcast Msg ID:</label>
						<input type="text" id="msg_id" name="msg_id" class="input-text" size="50" maxlength="50" disabled="disabled" value="1" />
					</div>

					<div class="form-field">
						<label for="message" class="cm-required">Broadcast Msg:</label>
						<textarea name="Push[message]" id="message" cols="55" rows="2" class="input-textarea-long"><?php echo $push['message']; ?></textarea>
						&nbsp;<div><font color="blue">( Best max: 200 characters )</font></div>

					</div>
					
					<div class="form-field">
                        <label>Status:</label>
                        <div class="select-field">
                            <input type="radio" name="Push[status]" id="user_data_0_a"
                                <?php if( $model['status']==='1') echo 'checked="checked"'; ?>
                                   value="1" class="radio" /><label for="user_data_0_a">Draft</label>
                            <input type="radio" name="Push[status]" id="user_data_0_d"
                                   <?php if( $model['status']!=='1') echo 'checked="checked"'; ?>
                                   value="0" class="radio" /><label for="user_data_0_d">Send</label>
                        </div>
                    </div>

                </fieldset>

            </div>

            <div class="buttons-container buttons-bg cm-toggle-button">
                <span  class="submit-button cm-button-main ">
                    <input type="submit" name="dispatch[profiles.update]" value="<?php echo $buttonTitle; ?>" />
                </span>
                &nbsp;&nbsp;&nbsp;
                <span class="cm-button-main cm-process-items">
                    <input type="button" onclick="location.href = '<?php echo $returnUrl.'&'.time(); ?>'"  value="Cancel" />
                </span>
            </div>
        </form>
    </div>
</div>

<?php

if( 0 )
{

?>

<script type='text/javascript'>
 $(function() {
 
 	//jquery.js
	//jquery.ui.js
	//jqueryui.css
	/*
    var availableTags = [
      "ActionScript",
      "AppleScript",
      "Asp",
      "BASIC",
      "C",
      "C++",
      "Clojure",
      "COBOL",
      "ColdFusion",
      "Erlang",
      "Fortran",
      "Groovy",
      "Haskell",
      "Java",
      "JavaScript",
      "Lisp",
      "Perl",
      "PHP",
      "Python",
      "Ruby",
      "Scala",
      "Scheme"
    ];*/
	
	//var availableTags = "Core Selectors Attributes Traversing Manipulation CSS Events Effects Ajax Utilities".split(" ");
	var availableTags = "Ajax advert adss sdv edc eaa 剧情 喜剧".split(" ");
	

	function split(val) {
		return val.split(/,\s*/);
	}
	function extractLast(term) {
		return split(term).pop();
	}

    $( "#username" ).autocomplete({
      //source: availableTags
	  minLength: 0,
	  //source: function(request, response) {
		//	response($.ui.autocomplete.filter(availableTags, extractLast(request.term)));
		//},
	  source : availableTags,
	  focus: function() {
			return false;
		},
		select: function(event, ui) {
			this.value = ui.item.value;
			//var terms = this.value.split(/,\s*/);
			//for(i in terms)
			//{
			//	if(terms[i]==ui.item.value)
			//		return false;
			//}
			//terms.pop();
			//terms.push( ui.item.value );
			//terms.push("");
			//this.value = terms.join(",");
			
			return false;
		}
    });
  });

			/*
			$("#username").tokenInput([
			{
				"name": "MaoMao",
				"email": "mao@gmail.com",
                "url": "/images/icon.png"
            },
            {
				"name": "YouYou",
				"email": "you@gmail.com",
                "url": "/images/icon.png"
            },
            {
				"name": "MengMeng",
				"email": "meng@gmail.com",
                "url": "/images/icon.png"
            },
            {
				"name": "YanYan",
				"email": "yan@gmail.com",
                "url": "/images/icon.png"
            },
          ], 
		  {
			  propertyToSearch: "name",
			  resultsFormatter: function(item) {
			  	return "<li>" + "<img src='" + item.url + "' title='" + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + "</div><div class='email'>" + item.email + "</div></div></li>" },
				//return item.first_name + " " + item.last_name },
              tokenFormatter: function(item) {
			  	return "<li><p>" + item.name + " <b style='color: red'>" + item.name + "</b></p></li>" },
		  });
		});
		*/
</script>

<?php } ?>