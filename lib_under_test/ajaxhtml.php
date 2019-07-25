<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<script type="text/javascript" src="../jquery.min.js"></script>
<script type="text/javascript" src="text.lib.alert.js"></script>

<script type = "text/javascript" >
//php () => javascript => {
//
//}

throw_alert ({
	form : {
		type: 'form',
		children : {
			input1 : {
				type: 'input',
				attr : {
					type :'text'
				}
			},
			input2 : {
				type: 'input',
				attr: {
					type : 'submit',
					value : 'Send'
				},
				events : {
						onclick : function (d) {
							return false;

					},
				call : {
					
				}
				
				}
			}
		}
	}
});


</script> </body> </html>