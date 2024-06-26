<?php
namespace Application\Entity;
use Concrete\Core\Entity\User\User;
use Concrete\Core\Support\Facade\Events;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Class Ticket
 * @ORM\Table(
 *     name="pkTicketsTicket",
 *     indexes={
 *     @ORM\Index(name="idxReference", columns={"reference"}),
 *     @ORM\Index(name="idxCreatedAt", columns={"createdAt"}),
 * })
 * @ORM\Entity(repositoryClass="Application\Repository\TicketRepository")
 * @ORM\HasLifecycleCallbacks()
 */

class Ticket
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $reference;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $location = '';
    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $description = '';

    /**
     * @ORM\ManyToOne(targetEntity="\Concrete\Core\Entity\User\User")
     * @ORM\JoinColumn(referencedColumnName="uID", nullable=true)
     */
    protected $creator;

    /**
     * @ORM\Column(type="array", nullable=false)
     */
    protected $comments = [];

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $open = true;

    public function __construct()
    {
        $this->createdAt = new Datetime();
        $this->reference = uniqid('TK.', true);
    }


    public function close() : self
    {
        $this->open = false;
        return $this;
    }

    public function open() : bool
    {
        return $this->open === true;
    }

    /**
     *
     * @return integer
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getReference() : ?string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return self
     */
    public function setReference(string $reference) : self
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt() : DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getLocation() : ?string
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return self
     */
    public function setLocation(string $location) : self
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription() : ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return self
     */
    public function setDescription(string $description) : self
    {
        $this->description = $description;
        return $this;
    }

    /**
     *
     * @return User
     */
    public function getCreator() : User
    {
        return $this->creator;
    }

    /**
     * @param User $creator
     * @return self
     */
    public function setCreator(User $creator) : self
    {
        $this->creator = $creator;
        return $this;
    }

    /**
     * @return array
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @return bool
     */
    public function hasComments(): bool
    {
        return count($this->comments) > 0;
    }

    /**
     * @param string $comment
     * @return self
     */
    public function addComment(string $comment, int $userId): self
    {
        $comment = trim($comment);
        if ($comment) {
            $this->comments[] = [
                'date' => new DateTime(),
                'userId' => $userId,
                'comment' => $comment,
            ];
        }
        return $this;
    }

    /**
     * @ORM\PostPersist
     * @return void
     */
    public function postPersistListener(): void
    {
        $event = new GenericEvent($this);
        Events::fire('on_ticket_create', $event);
    }

    /**
     * @ORM\PostUpdate
     * @return void
     */
    public function postUpdateListener(): void
    {
        $event = new GenericEvent($this);
        Events::fire('on_ticket_update', $event);
    }

}