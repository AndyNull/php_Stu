<?  
    include_once "./utils/db.php";
    $info = find_all_client_info($_SESSION["login_user_info"]);
?>
<div id="search_client_div">
    <div class="find_type_search_input_div">
        <input type="text" id="find_clientstr" placeholder="输入关键信息">
        <button class="find_btn" onclick="search_client_info()">搜索信息</button>
    </div>
    <div class="find_type_radiobtn_broup_div">
        <input type="radio" name="find_type_btn" value="id" id="userid"><label for="userid"><b>id</b></label>
        <input type="radio" name="find_type_btn" value="username" id="username" checked><label for="username"><b>用户名</b></label>
        <input type="radio" name="find_type_btn" value="phone" id="userphone"><label for="userphone"><b>手机</b></label>
        <input type="radio" name="find_type_btn" value="email" id="useremail"><label for="useremail"><b>邮箱</b></label>
    </div>
    <div class="find_info_show_div">
        <div id="btn_div"><button id="opt_client_all" onclick="add_client_info()">添加信息</button><button id="opt_client_all" onclick="opt_client_all('all')">全选</button><button onclick="opt_client_all('reelection')">反选</button><button onclick="del_client_info()">删除所选</button></div>
        <div id="info_table_div">
        <?  
            $str_list = ['选择','id','用户名','电话','邮箱','性别','上级','操作'];
            echo "<div class='client_info_table_head' style='position: sticky; top: 0;margin:0px'>";
            for($i=0;$i<count($str_list);$i++){
                echo "<div>".$str_list[$i]."</div>";
            }
            echo "</div>";
            for($i=0;$i<count($info);$i++){
                echo "<div class='client_info_table_centent' id='info".$info[$i][0]."'><div><input type='checkbox'name='client_opt_box' value='".$info[$i][0]."'></div>";
                for($j=0;$j<count($info[$i]);$j++){
                    echo "<div id='info".$info[$i][0]."0".$j."'>".$info[$i][$j]."</div>";
                }
                echo "<div><button onclick='edit_clientinfo(\"info".$info[$i][0]."\")'>编辑</button></div></div>";
            }
        ?>
    </div>
</div>

<script>
     //搜索客户信息
  function search_client_info(){
    str_list = JSON.parse('<? echo json_encode($info);?>');
    data_list = [];
    if($('#find_clientstr').val() == ""){
        $('#find_clientstr').attr('placeholder','请输入关键词,禁止为空！');
        document.getElementById("find_clientstr").select();
    }else{
        str = $('#find_clientstr').val();
        boxs = document.getElementsByName("find_type_btn");
        for(i=0;i<boxs.length;i++){
            if(boxs[i].checked){
                type = boxs[i].value;
            }
        }
        switch(type){
            case 'username':
                for(i=0;i<str_list.length;i++){
                    if(str_list[i][1].indexOf(str) != -1){
                        data_list.push(str_list[i]);
                    }
                }
                break;
            case 'id':
                for(i=0;i<str_list.length;i++){
                    if(str_list[i][0] == parseInt(str)){
                        data_list.push(str_list[i]);
                    }
                }
                break;
            case 'phone':
                for(i=0;i<str_list.length;i++){
                    if(str_list[i][2].indexOf(str) != -1){
                        data_list.push(str_list[i]);
                    }
                }
                break;
            case 'email':
                for(i=0;i<str_list.length;i++){
                    if(str_list[i][3].indexOf(str) != -1){
                        data_list.push(str_list[i]);
                    }
                }
                break;
        }
        $(".client_info_table_centent").remove()
        for(i=0;i<data_list.length;i++){
            $("#info_table_div").append('<div class="client_info_table_centent" id="info'+data_list[i][0]+'"><div><input type="checkbox" name="client_opt_box" value="'+data_list[i][0]+'"></div></div>');
            for(j=0;j<data_list[i].length;j++){
                $(".client_info_table_centent").eq(i).append('<div id="info'+data_list[i][0]+'0'+j+'">'+data_list[i][j]+'</div>');
            }
            $(".client_info_table_centent").eq(i).append('<div><button onclick="edit_clientinfo(\'info'+data_list[i][0]+'\')" >编辑</button></div>');
        }
    }
  }
</script>
<script src="./assets/js/client.js"></script>