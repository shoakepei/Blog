<!DOCTYPE html>
<html>
  
  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('admin/css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/xadmin.css') }}">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ asset('admin/lib/layui/layui.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset('admin/js/xadmin.js') }}"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>

    <div class="x-body">
      <div class="layui-row">
      </div>
      <!-- <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()">分类列表</button>
        <button class="layui-btn" onclick="x_admin_show('添加分类','{{url('/admin/cate/create')}}',600,400)"><i class="layui-icon"></i>添加</button>
      </xblock> -->
      <table class="layui-table">
        <thead>
          <tr>
          <!-- <th>
               <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th> -->
            <th>
              排序
            </th>
            <th>ID</th>
            <th>分类名称</th>
            <th>分类标题</th>
            <th>查看次数</th>
            <th>操作</th></tr>
        </thead>
        <tbody>
        @foreach($cates as $k=>$v)
          <tr>
          <!-- <th>
          <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{$v->cate_id}}'><i class="layui-icon">&#xe605;</i></div>
            </th> -->
            <td>
              <div class="layui-input-inline">
                <input onchange="changeOrder(this,{{ $v->cate_id }})" style="width: 40px;" type="text" id="L_cate_name" name="cate_order" value="{{ $v->cate_order }}" class="layui-input">
              </div>
            </td>
            <td>{{ $v->cate_id }}</td>
            <td>{{ $v->cate_names }}</td>
            <td>{{ $v->cate_title }}</td>
            <td>{{ $v->cate_view }}</td>

            <td class="td-manage">

              <a title="编辑"  onclick="x_admin_show('编辑','{{url('admin/cate/'.$v->cate_id.'/edit')}}',600,400)" href="javascript:;">
                <i class="layui-icon">&#xe642;</i>
              </a>
              <a title="查看文章"  onclick="x_admin_show('查看文章','{{url('admin/'.$v->cate_id.'/article')}}',600,400)" href="javascript:;">
                <i class="layui-icon">&#xe641;</i>
              </a>
              <a title="删除" onclick="member_del(this,'{{$v->cate_id}}')" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>

    </div>
    <script>
      layui.use(['form','laydate','layer'], function(){
        var laydate = layui.laydate;
        var form = layui.form;
        var layer = layui.layer;
        
        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });

          //监听提交
          form.on('submit(sreach)', function(data){
              // console.log(11111);
              // return false;
          });


      });

      //修改排序
      /*
      * @param obj 当前的文本框元素
      * @param id  当前分类记录的ID
      * */
      function changeOrder(obj,id) {
          // 文本框的值，也就是排序值
          var order = $(obj).val();
          //通过ajax 修改记录的排序
          $.post('/admin/cate/changeorder',{'order':order,'id':id,'_token':"{{ csrf_token() }}"},function(data){
              if(data.status == 0){
                  // 修改成功
                  layer.msg(data.msg,{icon:6});
                  // 刷新页面
                  location.reload();
              }else{
                  layer.msg(data.msg,{icon:5});
              }
          });
      }
      
       /*用户-停用*/
      function member_stop(obj,id){

          // 获取当前用户状态
          var status = $(obj).attr('data-id');
          layer.confirm('确认要停用吗？',function(index){


              if($(obj).attr('title')=='启用'){

                //发异步把用户状态进行更改
                  $.ajax({
                      type : "GET", //提交方式
                      url : '/admin/cate/changestate',//路径
                      data : {"id":id,"status":status},//数据，这里使用的是Json格式进行传输
                      dataType : "Json",
                      success : function(result) {//返回数据根据结果进行相应的处理
                        if(result.status == 0){
                            $(obj).attr('title','停用')
                            $(obj).find('i').html('&#xe62f;');

                            $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                            layer.msg('已停用!',{icon: 5,time:1000});
                        }else{
                            layer.msg('状态修改失败!',{icon: 5,time:1000});
                        }

                      }
                  });
              }else{
                  if(result.status == 0){
                      $(obj).attr('title','启用')
                      $(obj).find('i').html('&#xe601;');

                      $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                      layer.msg('已启用!',{icon: 5,time:1000});
                  }else{
                      layer.msg('状态修改失败!',{icon: 5,time:1000});
                  }

              }
              
          });
      }

      /*分类-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              // $.post('URL地址'.'携带的参数',成功后的闭包函数)
              $.post('{{ url('admin/cate/') }}/'+id,{"_token":"{{csrf_token()}}","_method":"delete","id":"cate_id"},function(data){
                  if(data.status == 0){
                      $(obj).parents("tr").remove();
                      layer.msg('已删除!',{icon:1,time:1000});
                      location.reload(true);
                  }else{
                      layer.msg('删除失败!',{icon:1,time:1000});
                      location.reload(true);
                  }
              });
          });
      }



      function delAll (argument) {

        //var data = tableCheck.getData();
        //   获取选中的记录,获取记录的id
        var ids = [];

          $('.layui-form-checked').not('.header').each(function(i,v){
            ids.push($(v).attr('data-id'));
          })
        console.log(ids);

          $.get('/admin/cate/del',{"ids":ids},function(data){
              if(data.status == 0){
                  layer.msg('删除成功', {icon: 1});
                  $(".layui-form-checked").not('.header').parents('tr').remove();
                  location.reload(true);
              }else{
                  layer.msg('删除失败', {icon: 1});
                  location.reload(true);
              }
          })
        // layer.confirm('确认要删除吗？'+data,function(index){
        //     //捉到所有被选中的，发异步进行删除

        // });
        }
    </script>
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();</script>
  </body>

</html>