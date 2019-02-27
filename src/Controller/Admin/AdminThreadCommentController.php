<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\IdeasWorkshop\ThreadComment;
use AppBundle\Entity\Report\IdeasWorkshop\ThreadCommentReport;
use AppBundle\IdeasWorkshop\Events;
use AppBundle\Report\ReportManager;
use AppBundle\Repository\ReportRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/ideasworkshop-threadcomment/{uuid}")
 * @Security("has_role('ROLE_ADMIN_IDEAS_WORKSHOP')")
 * @Entity("comment", expr="repository.findOneByUuid(uuid, true)")
 */
class AdminThreadCommentController extends Controller
{
    use RedirectToTargetTrait;
    use ResolveReportTrait;

    /**
     * Moderates a thread comment.
     *
     * @Route("/disable", methods={"GET"}, name="app_admin_thread_comment_disable")
     */
    public function disableAction(
        Request $request,
        ThreadComment $comment,
        ObjectManager $manager,
        EventDispatcherInterface $dispatcher,
        ReportRepository $reportRepository,
        ReportManager $reportManager
    ): Response {
        $comment->disable();

        $dispatcher->dispatch(Events::THREAD_COMMENT_DISABLE, new GenericEvent($comment));
        $this->resolveReportsFor(ThreadCommentReport::class, $comment, $reportRepository, $reportManager);

        $manager->flush();
        $this->addFlash('sonata_flash_success', sprintf('Le commentaire « %s » a été modéré avec succès.', $comment->getUuid()));

        return $this->prepareRedirectFromRequest($request)
            ?? $this->redirectToRoute('admin_app_ideasworkshop_thread_show', ['id' => $comment->getThread()->getId()]);
    }

    /**
     * Enable a thread comment.
     *
     * @Route("/enable", methods={"GET"}, name="app_admin_thread_comment_enable")
     */
    public function enableAction(
        Request $request,
        ThreadComment $comment,
        ObjectManager $manager,
        EventDispatcherInterface $dispatcher,
        ReportRepository $reportRepository,
        ReportManager $reportManager
    ): Response {
        $comment->enable();

        $dispatcher->dispatch(Events::THREAD_COMMENT_ENABLE, new GenericEvent($comment));
        $this->resolveReportsFor(ThreadCommentReport::class, $comment, $reportRepository, $reportManager);

        $manager->flush();
        $this->addFlash('sonata_flash_success', sprintf('Le commentaire « %s » a été activé avec succès.', $comment->getUuid()));

        return $this->prepareRedirectFromRequest($request)
            ?? $this->redirectToRoute('admin_app_ideasworkshop_thread_show', ['id' => $comment->getThread()->getId()]);
    }
}
