<!-- +++ content-main -->
<div id="content-main">
  <div id="content-form">
    <div align="left">
      <p class="title">エラー、配信停止メールアドレス削除ツール</p>
      <p class="inside"><font size="3">配信リストcsvと削除用（配信停止、エラー一覧等）csvを選択して「解析」ボタンをクリックしてください。
      削除済みのCSVファイルのダウンロードが始まります。</font><br />
      <br /></p>
      <p class="red12">※※※注意点※※※<br />
      ・配信リストcsvは「ピクトメール用」と同じ形式ですので、A列がお名前、B列がメールアドレスとなります。
      <a href="/member/pictmail/mail/pictmail.csv" target="_blank">詳しい形式はこちら</a><br />
      ・解析前と、解析後にダウンロードしたCSVとはメールアドレスの順番が入れ替わることがあります。<br />
      ・件数が多い場合処理に数分かかる恐れがございます。</br>
      <p><hr></p>
      <div class="red12"><?php echo $form->error('TempParseCsv.noData',null,array('escape'=>false)); ?></div>
      <form action="" method="POST" enctype="multipart/form-data">
        <table class="black12">

          <tr>
            <td>配信リストcsv</td>
            <td>
              <p><?php echo $form->file('ParseCsv.csv1'); ?></p>
              <div class="red12"><?php echo $form->error('csv1'); ?></div>
            </td>
          </tr>
          <tr>
            <td>削除用csv</td>
            <td>
              <p><?php echo $form->file('ParseCsv.csv2'); ?></p>
              <div class="red12"><?php echo $form->error('csv2'); ?></div>
            </td>
          </tr>
          </table>
          </div> <!-- content-form -->
        <?php echo $form->submit('解析', array('value' => '解析', 'name' => 'data[submit][upload]', 'div' => false)); ?>
      </form>


  </div> <!-- left -->
</div> <!-- content-main -->
<!-- /// content-main -->

