<?php
namespace Colzak\UserBundle\Security\Core\User;
 
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Colzak\UserBundle\Document\Profile;
 
class FOSUBUserProvider extends BaseClass
{
    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * @var DocumentManager
     */
    protected $documentManager;

    /**
     * @var array
     */
    protected $properties;

    /**
     * Constructor.
     *
     * @param UserManagerInterface $userManager FOSUB user provider.
     * @param array                $properties  Property mapping.
     */
    public function __construct(UserManagerInterface $userManager, DocumentManager $documentManager, array $properties)
    {
        $this->userManager = $userManager;
        $this->properties  = $properties;
        $this->documentManager = $documentManager;
    }
 
    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();
 
        //on connect - get the access token and the user ID
        $service = $response->getResourceOwner()->getName();
 
        $setter = 'set'.ucfirst($service);
        $setter_id = $setter.'Id';
        $setter_token = $setter.'AccessToken';
 
        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }
 
        //we connect current user
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());
 
        $this->userManager->updateUser($user);
    }
 
    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        // $dm = $this->get('doctrine_mongodb')->getManager();
        $username = $response->getUsername();
        // $user = $this->userManager->findUserBy(array($this->getProperty($response) => $username));
        $fbData = $response->getResponse();
        $user = $this->documentManager->getRepository('ColzakUserBundle:User')->findBy(array('facebookId' => $fbData['id']));
        var_dump($fbData);
        // die();
        //when the user is registrating
        if (null === $user) {
            $service = $response->getResourceOwner()->getName();
            $setter = 'set'.ucfirst($service);
            $setter_id = $setter.'Id';
            $setter_token = $setter.'AccessToken';


            // create new user here
            $user = $this->userManager->createUser();
            $user->$setter_id($username);
            $user->$setter_token($response->getAccessToken());


            //I have set all requested data with the user's username
            //modify here with relevant data
            $user->addRole('ROLE_FACEBOOK');
            $user->setUsername($this->documentManager->getRepository('ColzakUserBundle:User')->generateUniqueUsername($fbData));
            $user->setEmail($fbData['email']);

            $rdPassword = $this->randomPassword();
            $user->setPlainPassword($rdPassword);
            $user->setEnabled(true);

            $profile = new Profile();
            $profile->setUsername($user->getUsername());
            if (isset($fbData['last_name'])) {
                $profile->setLastname($fbData['last_name']);
            }
            if (isset($fbData['first_name'])) {
                $profile->setFirstname($fbData['first_name']);
            }
            if (isset($fbData['birthday'])) {
                $profile->setBirthdate(new \Datetime($fbData['birthday']));
            }
            if (isset($fbData['location'])) {
                $profile->setLocality($fbData['location']['name']);
            }
            if (isset($fbData['gender'])) {
                if ($fbData['gender'] == 'male')
                    $profile->setGender(Profile::GENDER_MALE);
                else
                    $profile->setGender(Profile::GENDER_FEMALE);
            }
            $user->setProfile($profile);
            $this->userManager->updateUser($user);

            //Envoyer mail avec le mdp + expliquer qu'il faut choisir le type de profil en allant sur son profil.

            return $user;
        }

        
        \Doctrine\Common\Util\Debug::dump($user); die();
 
        //if user exists - go with the HWIOAuth way
        $user = parent::loadUserByOAuthUserResponse($response);
 
        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
 
        //update access token
        $user->$setter($response->getAccessToken());
 
        \Doctrine\Common\Util\Debug::dump($user); die();
        return $user;
    }

    private function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
 
}