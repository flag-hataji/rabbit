<!-- +++ content-main -->
<div id="content-main">
  <div id="content-form">
    <div align="left">
      <p class="title">���顼���ۿ���ߥ᡼�륢�ɥ쥹����ġ���</p>
      <p class="inside"><font size="3">�ۿ��ꥹ��csv�Ⱥ���ѡ��ۿ���ߡ����顼��������csv�����򤷤ơֲ��ϡץܥ���򥯥�å����Ƥ���������
      ����Ѥߤ�CSV�ե�����Υ�������ɤ��Ϥޤ�ޤ���</font><br />
      <br /></p>
      <p class="red12">�����������������<br />
      ���ۿ��ꥹ��csv�ϡ֥ԥ��ȥ᡼���ѡפ�Ʊ�������Ǥ��Τǡ�A�󤬤�̾����B�󤬥᡼�륢�ɥ쥹�Ȥʤ�ޤ���
      <a href="/member/pictmail/mail/pictmail.csv" target="_blank">�ܤ��������Ϥ�����</a><br />
      ���������ȡ����ϸ�˥�������ɤ���CSV�Ȥϥ᡼�륢�ɥ쥹�ν��֤������ؤ�뤳�Ȥ�����ޤ���<br />
      �������¿���������˿�ʬ�����붲�줬�������ޤ���</br>
      <p><hr></p>
      <div class="red12"><?php echo $form->error('TempParseCsv.noData',null,array('escape'=>false)); ?></div>
      <form action="" method="POST" enctype="multipart/form-data">
        <table class="black12">

          <tr>
            <td>�ۿ��ꥹ��csv</td>
            <td>
              <p><?php echo $form->file('ParseCsv.csv1'); ?></p>
              <div class="red12"><?php echo $form->error('csv1'); ?></div>
            </td>
          </tr>
          <tr>
            <td>�����csv</td>
            <td>
              <p><?php echo $form->file('ParseCsv.csv2'); ?></p>
              <div class="red12"><?php echo $form->error('csv2'); ?></div>
            </td>
          </tr>
          </table>
          </div> <!-- content-form -->
        <?php echo $form->submit('����', array('value' => '����', 'name' => 'data[submit][upload]', 'div' => false)); ?>
      </form>


  </div> <!-- left -->
</div> <!-- content-main -->
<!-- /// content-main -->

