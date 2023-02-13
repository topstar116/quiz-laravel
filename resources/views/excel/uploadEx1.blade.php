<x-app-layout>

  <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                <div class ="container mx-10">

                  <div class="container-fluid mx-20 my-10">
                    <td width=170 rowspan=2>
                      <table border=0  align=right>
                          <td align="center">
                            <font color =blue>
                        <使い方動画>
                          </font>
                        </td>
                          <tr>
                        <td align="center">
                              <a href="https://youtu.be/wFeIstkxrWI" target="_blank">Ex1_広告費削減施策<a/>
                        </td>
                        <tr>
                        <td align="center">
                          <img border="0"  src="{{ asset('qrcode/QR_Ex1 広告費削減施策 解説動画.png')}}" width="160">
                        </td>
                      </table>
                    </td>
                  </div>



<div class="container-fluid">
<font size =6 color = "black "> 
@if($file_type == 'csv')
Ex1_広告費削減施策P1
@elseif($file_type == 'excel')
Ex1_広告費削減施策P2
@endif        
</font>

<form action="{{ route('uploadEx1_post') }}" name="form" method="post" enctype="multipart/form-data" class="my-10">
    @csrf
    <strong>
      <table>
            <td>
            <label for="checkbox_target_disp">
            <input type="checkbox" id='checkbox_target_disp' name ='checkbox_target_disp'  checked>
            <input type="hidden" name ='checkbox_target' id='checkbox_target'>
            <font size =5 color = red > 商品ターゲティング広告を利用する</font><br>
            <font size = 2.5 color = gray>
              商品ターゲティング広告を利用する場合はチェックを入れて下さい。
              </font>

            </td>
            <tr>
            <tr>
      </table>

      <table >
        <td>
        売上下位:
      </td>
      <td>
        <input type="number" name="sales_lower_rate" value="50.0" placeholder="50.0" step="any" required id="id_sales_lower_rate"> %以下
      </td>
        <tr>
          <td>
          インプレッション:
        </td>
        <td>
          <input type="number" name="impression" value="500" placeholder="500" required id="id_impression"> 以上
        </td>
          <tr>
            <td>
            売上高に占める広告費の割合 （ACoS):
          </td>
          <td>
            <input type="number" name="acos" value="50.0" placeholder="50.0" step="any" required id="id_acos"> %以上
          </td>
          <tr>

          <td>
          @if($file_type == 'csv')
          ファイル1:
          @elseif($file_type == 'excel')
          ファイル2:
          @endif        
        
        </td>

        <td>
        <input type="file" name="file" required id="id_file">
        </td>

      </table>

    </strong>

  @if($file_type == 'csv')
  <font color = "red ">「ASIN別 詳細ページ売上・トラフィック」ファイルを選択して下さい。</font><br>
  <input name="file_type" type="hidden" value="csv">
  @elseif($file_type == 'excel')
  <font color = "red ">「バルク操作ファイル６０日分」ファイル選択して下さい。</font><br>
  <input name="file_type" type="hidden" value="excel">
  @endif


  <button type="submit" class="rounded-noneinline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">実行</button>

  

</form>


<script type="text/javascript">

function checkbox_value_copy()
           {
document.getElementById('checkbox_target').value = checkbox_target_disp.checked;


           }
</script>


</div>
                </div>
              </div>
            </div>
        </div>
    </div>
</x-app-layout>
