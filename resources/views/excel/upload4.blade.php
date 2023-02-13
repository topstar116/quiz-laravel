<x-app-layout>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">


          <div class="container mx-10">

            <div class="container-fluid  my-10 mx-20">
              <td width=170 rowspan=2>
                <table border=0 align=right>
                  <td align="center">
                    <font color=blue>
                      <使い方動画>
                    </font>
                  </td>
                  <tr>
                    <td align="center">
                      <a href="https://youtu.be/WmF7NnTw_x4" target="_blank">4_マニュアル保留設定<a />
                    </td>
                  <tr>
                    <td align="center">
                      <img border="0" src="{{ asset('qrcode/QR_4 マニュアル保留設定 解説動画.png')}}" width="160">
                    </td>
                </table>
              </td>
            </div>

            <div class="container-fluid">
              <font size=6 color="black ">
                4_マニュアル保留設定
              </font>
              <form action="excel/upload4" method="post" enctype="multipart/form-data" class="my-10">
                @csrf
                <strong>
                  <table>
                    <td>
                      <label for="word_checkbox">
                        <input type="checkbox" id='word_checkbox' name='checkbox_target' checked>
                        <font size=5 color="red "> 商品ターゲティング広告を利用する</font><br>
                        <t>
                          <font size=2.5 color=gray>
                            商品ターゲティング広告を利用する場合はチェックを入れて下さい。
                          </font>

                    </td>
                    <tr>
                    <tr>
                  </table>

                  <table>
                    <td>
                      クリックスルー率:
                    </td>
                    <td>
                      <input type="number" name="click_through" value="0.3" placeholder="0.3" step="any" required id="id_click_through"> %未満
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
                        コンバージョン率:
                      </td>
                      <td>
                        <input type="number" name="conversion" value="2.0" placeholder="2.0" step="any" required id="id_conversion"> %以下
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
                <font color="red ">「バルク操作ファイル６０日分 」ファイル選択して下さい。</font><br>

                <button type="submit" class="rounded-noneinline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">実行</button>

              </form>



            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>