<?php
    $link=mysqli_connect('127.0.0.1', 'root', 123,'school');
/*
 * ���ܱ���5�ŷֱ�,�ܱ����50������
 */    
//    $create_table="create table student(id int(10) auto_increment primary key,name varchar(150))";
//    mysqli_query($link, $create_table) or die(mysqli_error($link));
//    for($i=1;$i<=5;$i++){
//        $create_son_table="create table student{$i}(id int(10) auto_increment primary key,name varchar(150))";
//        mysqli_query($link,$create_son_table);        
//    }
//    for($i=1;$i<=50;$i++){
//        $sql="insert into student(name) value('xiaoming{$i}')";
//        mysqli_query($link, $sql) or die(mysqli_error($link));
//    }
/*
 * �ֱ������10������
 */    
//    for($i=1;$i<=5;$i++){
//        $j = $i == 5 ? 0 : $i;
//        $sql="insert into student{$i}(select * from student where id%5 = $j )";
//        mysqli_query($link, $sql);
//    }
/*
 * �ֱ��ѯ�ϲ�,����ֱ����union
 */
    $sql = '';
    for($i=1;$i<=5;$i++){
        //$sql .=" select * from student{$i} union ";//������
        $sql .= "(select * from student{$i}) union";//����
    }
    $sql .= substr($sql , 0 , -5);
    $sql .= 'order by id desc';
    $result=mysqli_query($link,$sql);
    $list=mysqli_fetch_all($result);
    print_r($list);exit;
?>