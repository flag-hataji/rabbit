<!-- +++ content-main -->
<div id="content-main">
  <div id="content-form">
    <div align="left">
      <p ><font size="4">���顼���ۿ���ߥ᡼�륢�ɥ쥹����ġ���</font></p>
      <p ><font size="3">�ۿ��ꥹ��csv�Ⱥ���ѡ��ۿ���ߡ����顼��������csv�����򤷤ơֺ�����ϡץܥ���򥯥�å����Ƥ���������<br />
      ����Ѥߤ�CSV�ե�����Υ�������ɤ��Ϥޤ�ޤ���</font><br />
      <br /></p>
      <p class="red12">�����������������<br />
      ���ۿ��ꥹ��csv��rabbit-mail���ۿ�������Ʊ���ǡ�A�󤬤�̾����B�󤬥᡼�륢�ɥ쥹�Ȥʤ�ޤ���<br />
      �������csv�ϡ����顼��������ɤΡ֥᡼�륢�ɥ쥹�Τߥ�������ɡפǥ�������ɤ���CSV�����Ѥ��Ʋ�������<br />
      ���������ȡ����ϸ�˥�������ɤ���CSV�Ȥϥ᡼�륢�ɥ쥹�ν��֤������ؤ�뤳�Ȥ�����ޤ���<br />
      �������¿���������˿�ʬ�����붲�줬�������ޤ���</br>
      <p><hr></p>
      <form action="" method="POST" enctype="multipart/form-data">
        <table class="black12">

          <tr>
            <td>�ۿ��ꥹ��csv</td>
            <td>
              <p><?php echo $form->file('ParseCsv.csv1'); ?></p>
            </td>
          </tr>
          <tr>
            <td>����ѡʥ��顼��csv</td>
            <td>
              <p><?php echo $form->file('ParseCsv.csv2'); ?></p>
            </td>
          </tr>
          </table>
          </div> <!-- content-form -->
        <?php echo $form->submit('�������', array('value' => '�������', 'name' => 'data[submit][upload]', 'div' => false)); ?>
      </form>


  </div> <!-- left -->
</div> <!-- content-main -->
<!-- /// content-main -->
