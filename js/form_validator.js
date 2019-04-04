
function login_form_reg(){
    
	var reg_email = document.getElementById('reg_email');
        var reg_uname = document.getElementById('reg_uname');
        var reg_password = document.getElementById('reg_password');
        var reg_check3 = document.getElementById('reg_check3');
        var div_error_box='div_error_box_reg';
     
        if(notEmpty(reg_uname, "Name Required.",div_error_box)){
            if(lengthRestriction(reg_uname, 3, 25,div_error_box)){
                if(notEmpty(reg_email, "Email Required.",div_error_box)){
                if(emailValidator(reg_email, "Please enter a valid email address",div_error_box)){
                     if(notEmpty(reg_password, "Password Required.",div_error_box)){
                         if(lengthRestriction(reg_password, 4, 25,div_error_box)){
                            if(isCheckbox(reg_check3,'Please Accept Terms And Conditions',div_error_box)){
                             return true;
                            }
                         }
                     }
                }
            }
        }
    }
	return false;
	
}
function login_form_login(){
     var uname_log = document.getElementById('uname_log');
        var password_log = document.getElementById('password_log');
        var div_error_box='div_error_box_login';
         if(notEmpty(uname_log, "Email Required.",div_error_box)){
               if(emailValidator(uname_log, "Please enter a valid email address",div_error_box)){ 
              if(notEmpty(password_log, "Password Required.",div_error_box)){
                         if(lengthRestriction(password_log, 4, 25,div_error_box)){
                            return true;
                        }
                     }
                }
         }
	return false;
}
function popup_form_reg(){
    
	var reg_email = document.getElementById('reg_email');
        var reg_uname = document.getElementById('reg_uname');
        var reg_password = document.getElementById('reg_password');
        var reg_check3 = document.getElementById('pop_check3_reg');
        var div_error_box='popup_div_error_box_reg';
     
        if(notEmpty(reg_uname, "Name Required.",div_error_box)){
            if(lengthRestriction(reg_uname, 3, 25,div_error_box)){
                if(notEmpty(reg_email, "Email Required.",div_error_box)){
                if(emailValidator(reg_email, "Please enter a valid email address",div_error_box)){
                     if(notEmpty(reg_password, "Password Required.",div_error_box)){
                         if(lengthRestriction(reg_password, 4, 25,div_error_box)){
                            if(isCheckbox(reg_check3,'Please Accept Terms And Conditions',div_error_box)){
                             return true;
                            }
                         }
                     }
                }
            }
        }
    }
	return false;
	
}
function popup_form_login(){
     var uname_log = document.getElementById('pop_uname_login');
     var password_log = document.getElementById('pop_password_login');
     var div_error_box='popup_div_error_box_login';
         if(notEmpty(uname_log, "Email Required.",div_error_box)){
               if(emailValidator(uname_log, "Please enter a valid email address",div_error_box)){ 
              if(notEmpty(password_log, "Password Required.",div_error_box)){
                         if(lengthRestriction(password_log, 4, 25,div_error_box)){
                            return true;
                        }
                     }
                }
         }
	return false;
}
function formValidator(){
	// Make quick references to our fields
	var firstname = document.getElementById('firstname');
	var addr = document.getElementById('addr');
	var zip = document.getElementById('zip');
	var state = document.getElementById('state');
	var username = document.getElementById('username');
	var email = document.getElementById('email');
	
	// Check each input in the order that it appears in the form!
	if(isAlphabet(firstname, "Please enter only letters for your name")){
		if(isAlphanumeric(addr, "Numbers and Letters Only for Address")){
			if(isNumeric(zip, "Please enter a valid zip code")){
				if(madeSelection(state, "Please Choose a State")){
					if(lengthRestriction(username, 6, 8)){
						if(emailValidator(email, "Please enter a valid email address")){
							return true;
						}
					}
				}
			}
		}
	}
	
	
	return false;
	
}

function notEmpty(elem, helperMsg,div_error_box){
	if(elem.value.length == 0){
		var error_box=document.getElementById(div_error_box);
		error_box.innerHTML=helperMsg;
		//alert(helperMsg);
		elem.focus(); // set the focus to this input
		return false;
	}
	return true;
}

function isCheckbox(elem,helperMsg,div_error_box){
	if(elem.checked==true){
		return true;
	}else{
		var error_box=document.getElementById(div_error_box);
		error_box.innerHTML=helperMsg;
		elem.focus();
		return false;
	}
}
function isNumeric(elem, helperMsg){
	var numericExpression = /^[0-9]+$/;
	if(elem.value.match(numericExpression)){
		return true;
	}else{
		var error_box=document.getElementById(div_error_box);
		error_box.innerHTML=helperMsg;
		elem.focus();
		return false;
	}
}

function isAlphabet(elem, helperMsg,div_error_box){
	var alphaExp = /^[a-zA-Z]+$/;
	if(elem.value.match(alphaExp)){

		return true;
	}else{
		var error_box=document.getElementById(div_error_box);
		error_box.innerHTML=helperMsg;
		//alert(helperMsg);
		elem.focus();
		return false;
	}
}

function isAlphanumeric(elem, helperMsg,div_error_box){
	var alphaExp = /^[0-9a-zA-Z]+$/;
	if(elem.value.match(alphaExp)){
		return true;
	}else{
		var error_box=document.getElementById(div_error_box);
		error_box.innerHTML=helperMsg;
		elem.focus();
		return false;
	}
}

function lengthRestriction(elem, min, max,div_error_box){
	var uInput = elem.value;
	if(uInput.length >= min && uInput.length <= max){
		return true;
	}else{
		var error_box=document.getElementById(div_error_box);
		error_box.innerHTML="Please enter between " +min+ " and " +max+ " characters";
		//alert("Please enter between " +min+ " and " +max+ " characters");
		elem.focus();
		return false;
	}
}

function madeSelection(elem, helperMsg,div_error_box){
	if(elem.value == "Please Choose"){
		var error_box=document.getElementById(div_error_box);
		error_box.innerHTML=helperMsg;
		elem.focus();
		return false;
	}else{
		return true;
	}
}

function emailValidator(elem, helperMsg,div_error_box){
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if(elem.value.match(emailExp)){
		return true;
	}else{
		var error_box=document.getElementById(div_error_box);
		error_box.innerHTML=helperMsg;
		elem.focus();
		return false;
	}
}