mui.init();
			var uname = document.getElementById("uname");
			var schoolcar = document.getElementById("schoolcar");
			var card = document.getElementById("card");
			var sex = document.getElementById("sex");
			var major = document.getElementById("major");
			var classid = document.getElementById("class");
			var fuzu = document.getElementById("fuzu");
			var zainum = document.getElementById("zainum");
			var ssnum = document.getElementById("ssnum");
			var tel = document.getElementById("tel");
			var shiyanban =document.getElementById("shiyanban");
			
				
			
			var btn = document.getElementById("reg");
					btn.addEventListener("tap",function(enent) {
					var userInfo = {
						uname : uname.value,
						schoolcar : schoolcar.value,
						card : card.value,
						sex : sex.value,
						major : major.value,
						classid : classid.value,
						fuzu : fuzu.value,
						zainum : zainum.value,
						ssnum : ssnum.value,
						shiyanban : shiyanban.value,
						tel : tel.value
						
					};
					if (userInfo.uname == "") {
						mui.toast('请输入姓名',{ duration:'long', type:'div' });
						return;
					}
					if (userInfo.schoolcar == "") {
						mui.toast('请输入学号',{ duration:'long', type:'div' });
						return;
					}
					if (userInfo.schoolcar.length !=8) {
							mui.toast('请输入八位学号',{ duration:'long', type:'div' });
							return
					}
					if (userInfo.card == "") {
						mui.toast('请输入身份证号',{ duration:'long', type:'div' });
						return;
					}
					
					if (userInfo.card.length !=18) {
						mui.toast('请输入正确的身份证号',{ duration:'long', type:'div' });
						return;
					}
					if (userInfo.tel == "") {
						mui.toast('请输入手机号',{ duration:'long', type:'div' });
						return;
					}
					if (userInfo.tel.length !=11) {
						mui.toast('请输入正确的手机号',{ duration:'long', type:'div' });
						return;
					}
					if (userInfo.zainum =="") {
						mui.toast('请输入斋号',{ duration:'long', type:'div' });
						return;
					}
					if (userInfo.ssnum =="") {
						mui.toast('请输入宿舍号',{ duration:'long', type:'div' });
						return;
					}
					if (userInfo.classid == "") {
						mui.toast('请输入班级',{ duration:'long', type:'div' });
						return;
					}
					if (userInfo.classid.length != 4) {
						mui.toast('请输入正确的班级',{ duration:'long', type:'div' });
						return;
					}
					if (userInfo.sex == "") {
						mui.toast('请选择性别',{ duration:'long', type:'div' });
						return;
					}
					if (userInfo.major == "") {
						mui.toast('请选择专业',{ duration:'long', type:'div' });
						return;
					}
					if (userInfo.shiyanban == "") {
						mui.toast('请选择是否为实验班',{ duration:'long', type:'div' });
						return;
					}
					if (userInfo.fuzu == "") {
						mui.toast('请选择你的辅导员',{ duration:'long', type:'div' });
						return;
					}
					
					
					
					

					mui.post(addurl,{
						name:userInfo.uname,
						number:userInfo.schoolcar,
						card:userInfo.card,
						sex:userInfo.sex,
						major:userInfo.major,
						class:userInfo.classid,
						fuzu:userInfo.fuzu,
						zainum:userInfo.zainum,
						ssnum:userInfo.ssnum,
						tel:userInfo.tel,
						shiyanban:userInfo.shiyanban
						},function(data){
						if(data.success == "ok"){
                                window.location.href="success";
							return;
						}else{
                            mui.alert(data.msg,"注意","确定");
                            return;
						}


					},'json'
					);
					});