<!-- +++ content-main -->
<div id="content-main">
  <div id="content-form">
    <div align="left">
      <p ><font size="4">エラー、配信停止メールアドレス削除ツール</font></p>
      <p ><font size="3">配信リストcsvと削除用（配信停止、エラー一覧等）csvを選択して「削除開始」ボタンをクリックしてください。<br />
      削除済みのCSVファイルのダウンロードが始まります。</font><br />
      <br /></p>
      <p class="red12">※※※注意点※※※<br />
      ・配信リストcsvはrabbit-mailの配信形式と同じで、A列がお名前、B列がメールアドレスとなります。<br />
      ・削除用csvは、エラーダウンロードの「メールアドレスのみダウンロード」でダウンロードしたCSVを利用して下さい。<br />
      ・解析前と、解析後にダウンロードしたCSVとはメールアドレスの順番が入れ替わることがあります。<br />
      ・件数が多い場合処理に数分かかる恐れがございます。</br>
      <p><hr></p>
      <form action="" method="POST" enctype="multipart/form-data">
        <table class="black12">

          <tr>
            <td>配信リストcsv</td>
            <td>
              <p><?php echo $form->file('ParseCsv.csv1'); ?></p>
            </td>
          </tr>
          <tr>
            <td>削除用（エラー）csv</td>
            <td>
              <p><?php echo $form->file('ParseCsv.csv2'); ?></p>
            </td>
          </tr>
          </table>
          </div> <!-- content-form -->
        <?php echo $form->submit('削除開始', array('value' => '削除開始', 'name' => 'data[submit][upload]', 'div' => false)); ?>
      </form>


  </div> <!-- left -->
</div> <!-- content-main -->
<!-- /// content-main -->
