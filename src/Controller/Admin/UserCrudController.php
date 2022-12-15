<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\{Action, Actions, Crud, KeyValueStore, Filters};
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\{IdField,
    Field,
    EmailField,
    TextField,
    FormField,
    AssociationField,
    BooleanField,
    ChoiceField,
    DateTimeField,
    NumberField,
    TextEditorField
};
use Symfony\Component\Form\Extension\Core\Type\{PasswordType, RepeatedType};
use Symfony\Component\Form\{FormBuilderInterface, FormEvent, FormEvents};
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            EmailField::new('email'),
            $password = TextField::new('password')
                ->setFormType(PasswordType::class)
                ->setFormTypeOption('empty_data', '')
                ->setRequired(false),
            TextField::new('name'),
            TextField::new('firstname'),
            ChoiceField::new('roles')->allowMultipleChoices()->setChoices([
                'Administrateur' => 'ROLE_ADMIN',
                'Utilisateur' => 'ROLE_USER'
            ])
        ];
    }

    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $plainPassword = $entityDto->getInstance()?->getPassword();
        $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);
        $this->addEncodePasswordEventListener($formBuilder, $plainPassword);

        return $formBuilder;
    }

    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);
        $this->addEncodePasswordEventListener($formBuilder);

        return $formBuilder;
    }

    protected function addEncodePasswordEventListener(FormBuilderInterface $formBuilder, $plainPassword = null): void
    {
        $formBuilder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use ($plainPassword) {
            /** @var User $user */
            $user = $event->getData();
            if ($user->getPassword() !== $plainPassword) {
                $user->setPassword($this->passwordEncoder->hashPassword($user, $user->getPassword()));
            }
        });
    }
//    public function configureFilters(Filters $filters): Filters
//    {
//        return $filters
//            ->add('sold')
//            ->add('created_at');
//    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW);
    }
}