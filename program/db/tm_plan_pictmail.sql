
 
-- �᡼�����ۿ������ƥ� DB
 

-------------------------------------------------
--  �ץ��ޥ���
-------------------------------------------------

DROP TABLE    tm_plan;
DROP SEQUENCE tm_plan_seq;

CREATE TABLE tm_plan (
  plan_id         int4 DEFAULT NEXTVAL('tm_plan_seq') PRIMARY KEY,
  plan            text NOT NULL,           -- �ץ��̾
  price_first     int4 NOT NULL,           -- ���������
  price_month     int4 NOT NULL,           -- ����(1����)
  price_month6    int4 NOT NULL,           -- ����(6����)
  price_year      int4 NOT NULL,           -- ����(1ǯ)
  send_max        int4 NOT NULL,           -- ����᡼��������
  month_max       int4 NOT NULL,           -- ���κ���᡼���������
  comment         text,                    -- ����
  flag_open       int2 NOT NULL DEFAULT 1, -- �罸�ե饰��0=�罸���, 1=�罸��
  date_update     timestamp DEFAULT now()  -- ������
);

-- �������󥹤κ���
CREATE SEQUENCE tm_plan_seq START 4;

-- ���¤�����
GRANT ALL ON tm_plan     TO pgsql ;
GRANT ALL ON tm_plan_seq TO pgsql ;
INSERT INTO tm_plan VALUES(1,'̵������ץ��', 5000,    0,     0,     0,    60, 3, '', 0);
INSERT INTO tm_plan VALUES(2,'�饤�ȥץ��',           5000, 1000,  6000, 12000,  6000, 2, '�ʤ�Ȥ��äƤ�ȳ��ǰ��ͤη��1050�ߡ�\n���̤������0.16�ߤǤ�������ǽ�ʬ������¿���Ϥ���\n����ۿ������狼��ʤ����Ϥޤ��ϥ饤�ȥץ�󤫤�ɤ���', 1);
INSERT INTO tm_plan VALUES(3,'����������ɥץ��',     5000, 2000, 12000, 24000, 25000, 5, '���̤�����0.08�ߡ�\n�饤�ȥץ��Ǥ�ʪ­��ʤ������ͤ�\n;͵���ۿ�����Υץ��Ǥ���', 1);
INSERT INTO tm_plan VALUES(4,'�������ѡ��ȥץ��',     5000, 5000, 30000, 60000, 70000, 5, '���̤�����0.07�ߤ����Ѥ�����\n���Ϥ��礭���ۿ��򤴴�˾�ξ��ϥ��졪', 1);
INSERT INTO tm_plan VALUES(5,'��������ץ��',      0,    0,     0,     0,     0, 1, '', 0);
INSERT INTO tm_plan VALUES(6,'�����ӥ��ץ��',      0,    0,     0,     0,  1000, 1, '', 0);

INSERT INTO tm_plan VALUES(7,'3000�߻Ȥ�����ץ��',2858,    0,     0,     0,  6000, 1, '���ǹ���3,000�ߥݥå����6,000�̤��ۿ�����ǽ��\n���������3000�߰ʳ��������ȯ���������ޤ���\n�����ѤǤ��뵡ǽ�����¤Ϥ���ޤ��� \n��6,000�̤��ۿ����֤����¤Ϥ���ޤ��󡪻Ȥ��ڤ�ޤǤ����Ѳ�ǽ�Ǥ���\n���֥��٥�Ȥ����ΰ�����֤����ۿ��������פȤ��ä����˺�Ŭ�Ǥ���\n��6000���ۿ���ˡ�����3000�ߥץ��˿�������Ǥ����������Ȥ��ǽ�Ǥ���', 1);

