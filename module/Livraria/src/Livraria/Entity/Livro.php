<?php

namespace Livraria\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="livros")
 * @ORM\Entity(repositoryClass="Livraria\Entity\LivroRepository")
 */
class Livro {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     *
     * @ORM\Column(type="text")
     * @var string 
     */
    protected $nome;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $autor;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $isbn;

    
   
    /**
     *
     * @ORM\ManyToOne(targetEntity="Livraria\Entity\Categoria", inversedBy="livros")
     * @ORM\JoinColumn(name="categoria_id",referencedColumnName="id")
     */
    protected $categoria;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $valor;

    public function __construct($options = null) {
        Configurator::configure($this, $options);
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getAutor() {
        return $this->autor;
    }

    function getIsbn() {
        return $this->isbn;
    }

    function getCategoria() {
        return $this->categoria;
    }

    function getValor() {
        return $this->valor;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setAutor($autor) {
        $this->autor = $autor;
    }

    function setIsbn($isbn) {
        $this->isbn = $isbn;
    }

    function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    public function toArray() {
        return array(
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'autor' => $this->getAutor(),
            'isbn' => $this->getIsbn(),
            'categoria' => $this->getId(),
            'valor' => $this->getValor()
        );
    }

}
