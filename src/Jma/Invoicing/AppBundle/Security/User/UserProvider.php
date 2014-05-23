<?php

namespace Jma\Invoicing\AppBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;

/**
 * Description of UserProvider
 *
 * @author Maarek
 */
class UserProvider implements UserProviderInterface
{

    /**
     * @var RepositoryInterface
     */
    private $entrepreneurRepo;
    private $users;

    /**
     * Constructor.
     *
     * The user array is a hash where the keys are usernames and the values are
     * an array of attributes: 'password', 'enabled', and 'roles'.
     *
     * @param RepositoryInterface $entrepreneurRepo
     * @param array $users An array of users
     */
    public function __construct(RepositoryInterface $entrepreneurRepo, array $users = array())
    {
        $this->entrepreneurRepo = $entrepreneurRepo;

        foreach ($users as $username => $attributes) {
            $password = isset($attributes['password']) ? $attributes['password'] : null;
            $roles = isset($attributes['roles']) ? $attributes['roles'] : array();
            $user = new User($username, $password, $roles);

            $this->createUser($user);
        }
    }

    /**
     * Adds a new User to the provider.
     *
     * @param UserInterface $user A UserInterface instance
     */
    public function createUser(UserInterface $user)
    {
        if (isset($this->users[strtolower($user->getUsername())])) {
            throw new \LogicException('Another user with the same username already exist.');
        }

        $this->users[strtolower($user->getUsername())] = $user;
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        if (!isset($this->users[strtolower($username)])) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        $user = $this->users[strtolower($username)];

        $entrepreneur = $this->entrepreneurRepo->findOneBy(array('username' => $user->getUsername()));
        $result = new User($user->getUsername(), $user->getPassword(), $user->getRoles());

        $result->setEntrepreneur($entrepreneur);

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $class === 'Jma\Invoicing\AppBundle\Security\User';
    }

}
