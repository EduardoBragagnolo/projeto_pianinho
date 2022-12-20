<?php

Class Usuario{
    
    private $pdo;
    public $msgErro = "";
    public function conectar($nome, $host, $usuario, $senha){
        global $pdo;
        try{
            $pdo = new PDO("mysql:dbname=".$nome.";host=".$host,$usuario,$senha);
        } catch (PDOException $e){
            $msgErro = $e->getMessage();
        }
        
    }
    
    public function cadastrar($nome, $usuario, $senha){
        global $pdo;
        //verificar se existe
        $sql = $pdo->prepare("select id_usuario from usuarios where email = :e");
        $sql->bindValue(":u,$usuario");
        $sql->execute();
        if($sql->rowCount > 0){
            return false; //já está cadastrado
        } else {
            $sql = $pdo->prepare("insert into usuarios(nome, usuario, senha) values(:n, :u, :s)");
            $sql->bindValue(":n",$nome);
            $sql->bindValue(":u",$usuario);
            $sql->bindValue(":s",md5($senha));
            $sql->execute();
            return true;
        }
    }
    
    public function logar($usuario, $senha){
        global $pdo;
        
        //verificar se já está cadastrado
        
        $sql = $pdo->prepare("select id_usuario from usuarios where usuario = :u and senha = :s");
        
        $sql->bindValue(":u",$usuario);
        $sql->bindValue(":s", md5($senha));
        $sql->execute();
        
        if($sql->rowCount()>0){
            //entrar na sessão
            $dado = $sql->fetch();
            session_start();
            $_SESSION['id_usuario'] = $dado['id_usuario'];
            return true; //logado com sucesso
        } else {
            return false;
        }
    }
    
    public function logged($nome){
        global $pdo;
        
        $array = array();
        $sql = $pdo->prepare("select usuario from usuarios where usuario = :u and senha = :s");
        $sql->bindValue(":u",$usuario);
        $sql->execute();
        
            if($sql->rowCount()>0){
                $dado = $sql->fetch();
                
            }
            
        return $array;        
    }
}







?>