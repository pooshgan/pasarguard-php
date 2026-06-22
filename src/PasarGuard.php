<?php

namespace Pooshgan\PasarGuard;

use Pooshgan\PasarGuard\Endpoints\AdminRole;
use Pooshgan\PasarGuard\Endpoints\User;
use Pooshgan\PasarGuard\Endpoints\Host;
use Pooshgan\PasarGuard\Endpoints\Group;
use Pooshgan\PasarGuard\Endpoints\Hwid;
use Pooshgan\PasarGuard\Endpoints\Setup;
use Pooshgan\PasarGuard\Endpoints\System;
use Pooshgan\PasarGuard\Endpoints\Core;
use Pooshgan\PasarGuard\Endpoints\Node;
use Pooshgan\PasarGuard\Endpoints\Subscription;
use Pooshgan\PasarGuard\Endpoints\UserTemplate;
use Pooshgan\PasarGuard\Endpoints\Admin;
use Pooshgan\PasarGuard\Endpoints\Settings;
use Pooshgan\PasarGuard\Endpoints\ClientTemplate;
use Pooshgan\PasarGuard\Endpoints\Home;

class PasarGuard
{
    public AdminRole $adminRoles;
    public User $users;
    public Host $hosts;
    public Group $groups;
    public Hwid $hwids;
    public Setup $setup;
    public System $system;
    public Core $cores;
    public Node $nodes;
    public Subscription $subscriptions;
    public UserTemplate $userTemplates;
    public Admin $admins;
    public Settings $settings;
    public ClientTemplate $clientTemplates;
    public Home $home;

    public function __construct(Client $client)
    {
        $this->adminRoles = new AdminRole($client);
        $this->users = new User($client);
        $this->hosts = new Host($client);
        $this->groups = new Group($client);
        $this->hwids = new Hwid($client);
        $this->setup = new Setup($client);
        $this->system = new System($client);
        $this->cores = new Core($client);
        $this->nodes = new Node($client);
        $this->subscriptions = new Subscription($client);
        $this->userTemplates = new UserTemplate($client);
        $this->admins = new Admin($client);
        $this->settings = new Settings($client);
        $this->clientTemplates = new ClientTemplate($client);
        $this->home = new Home($client);
    }
}