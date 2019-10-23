<?php

namespace App\Controller;

use App\Entity\Produto;
use App\Form\ProdutoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProdutoController extends AbstractController
{
    /**
     * @Route("/produto", name="listar_produto")
     * @Template("produto/index.html.twig")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $produtos = $em->getRepository(Produto::class)->findAll();

        return ["produtos" => $produtos];
    }

    /**
     * @param Request $request
     * @Route("/produto/cadastrar", name="cadastrar_produto")
     * @Template("produto/create.html.twig")
     * @return array
     */
    public function create(Request $request)
    {
        $produto = new Produto();

        //Aqui a Entity o Produto é vinculada ao form
        $form = $this->createForm(ProdutoType::class, $produto);

        /* No request vem o Post que foi enviado pelo formulário
         * Deste modo os dados do post são populado na entidade pelo Symfony
         *
         * O campo 'nome' do formulário presente em src/Form/ProdutoType
         * é viculado automaticamente ao atributo 'nome' da entidade
         */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($produto);
            $em->flush();

            $this->addFlash('success', 'O Produto foi salvo com sucesso!');
            return $this->redirectToRoute("listar_produto");
        }

        return ['form' => $form->createView()];
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("produto/editar/{id}", name="editar_produto")
     */
    public function update(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $produto = $em->getRepository(Produto::class)->find($id);

        $form = $this->createForm(ProdutoType::class, $produto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'O Produto ' . $produto->getNome() . ' foi salvo com sucesso!');
            return $this->redirectToRoute("listar_produto");
        }

        //Sem o Template na Annotation, nos metodos acima foi utilizado
        return $this->render("produto/update.html.twig", [
            'produto' => $produto,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @Route("produto/visualizar/{id}", name="visualizar_produto")
     * @return Response
     */
    public function view(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $produto = $em->getRepository(Produto::class)->find($id);

        return $this->render('produto/view.html.twig', [
            "produto" => $produto
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @Route("produto/apagar/{id}", name="apagar_produto")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $produto = $em->getRepository(Produto::class)->find($id);

        if (!$produto) {
            $mensagem = "O produto não foi encontrado!";
            $tipo = "warning";
        } else {
            $em->remove($produto);
            $em->flush();
            $mensagem = "O Produto foi excluido com sucesso";
            $tipo = "success";
        }

        $this->addFlash($tipo, $mensagem);
        return $this->redirectToRoute("listar_produto");
    }
}
