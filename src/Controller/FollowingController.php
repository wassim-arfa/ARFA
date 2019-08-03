<?php

namespace App\Controller;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("is_granted('ROLE_USER')")
 * @Route("/following")
 */
Class FollowingController extends AbstractController
{
/**
     * @Route("/follow/{id}", name="following_follow")
     */
public function Follow(User $userToFollow)
{
    $currentUser=$this->getUser();
if ($currentUser->getId() != $userToFollow->getId()) 
        {
            $currentUser->getFollowing()->add($userToFollow);
// dont have to persist $em->persist($currentUser); because 'add' do auto persist in collection
            $em=$this->getDoctrine()->getManager()->flush();
        }
return $this->redirectToRoute('user_profile',['id'=>$userToFollow->getId()]);

}
/**
     * @Route("/unfollow/{id}", name="following_unfollow")
     */
public function Unfollow(User $userToUnfollow)
    {
        $currentUser=$this->getUser();
        $currentUser->getFollowing()->removeElement($userToUnfollow);
        $em=$this->getDoctrine()->getManager()->flush();
return$this->redirectToRoute('user_profile',['id'=>$userToUnfollow->getId()]);

}
}