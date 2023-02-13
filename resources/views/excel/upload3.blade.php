<x-app-layout>

  <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    

                <div class ="container mx-10 my-10">

                  <div class="container-fluid mx-10">
                    <td width=170 rowspan=2>
                      <table border=0  align=right>
                        <td align="center">
                          <font color =blue>
                      <使い方動画>
                        </font>
                      </td>
                        <tr>
                      <td align="center">
                            <a href="https://youtu.be/gYunJ5KgCTk" target="_blank">3_入札額調整<a/>
                      </td>
                      <tr>
                      <td align="center">
                        <img border="0"  src="{{ asset('qrcode/QR_3 入札額調整 解説動画.png')}}" width="160">
                      </td>
                      <tr>
                      <td align="center">
                        <a href="{{ asset('qrcode/3_入札額調整範囲.jpg')}}" target="_blank">
                          <img border="0" src="{{ asset('qrcode/3_入札額調整範囲.jpg')}}" width="520">
                          <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp クリックすると拡大します。
                        </a>
                      </td>
                      </table>
                    </td>
                  </div>

<div class="container-fluid">
<font size =6 color = "black "> 
3_入札額調整
</font>
<form action="excel/upload3" method="post" enctype="multipart/form-data" class="my-10">
  @csrf
  <strong>
    <table>
          <td>
          <label for="word_checkbox">
          <input type="checkbox" id='word_checkbox' name ='checkbox_target' checked  >
          <font size =5 color = "red "> 商品ターゲティング広告を利用する</font><br>
          <t> <font size = 2.5 color = gray>
            商品ターゲティング広告を利用する場合はチェックを入れて下さい。
            </font>

          </td>
          <tr>
          <tr>
    </table>

    <table >
      <td>
      インプレッション第1基準:
    </td>
    <td>
      <input type="number" name="impression1" value="1000" placeholder="1000" required id="id_impression1"> 以上
    </td>   

      <tr>
        <td>
        インプレッション第2基準:
      </td>
      <td>
        <input type="number" name="impression2" value="500" placeholder="500" required id="id_impression2"> 未満
      </td>
        <tr>
          <td>
          クリックスルー率第1基準:
        </td>
        <td>
          <input type="number" name="click_through1" value="0.5" placeholder="0.5" step="any" required id="id_click_through1"> %以上
        </td>
          <tr>
            <td>
            クリックスルー率第2基準:
          </td>
          <td>
            <input type="number" name="click_through2" value="0.3" placeholder="0.3" step="any" required id="id_click_through2"> %未満
          </td>
            <tr>
              <td>
              クリックスルー率第3基準:
            </td>
            <td>
              <input type="number" name="click_through3" value="0.2" placeholder="0.2" step="any" required id="id_click_through3"> %未満
            </td>
              <tr>
                <td>
                クリックスルー率第4基準:
              </td>
              <td>
                <input type="number" name="click_through4" value="0.1" placeholder="0.1" step="any" required id="id_click_through4"> %未満
              </td>
                <tr>

        <td>
      ファイル:
      </td>

      <td>
      <input type="file" name="file" required id="id_file">
      </td>

      </table>

  </strong>

  <font color = "red ">「バルク操作ファイル７日分 」ファイル選択して下さい。</font><br>

  <button type="submit" class="rounded-noneinline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">実行</button>

</form>


</div>
                </div>
              </div>
            </div>
        </div>
    </div>
</x-app-layout>

