export const settingsMenuMixin = {
    data(){
        return {
            menuList: [
                {
                    label: "Configurações",
                    icon: "cog",
                    link: "settings",
                    linkType: "route",
                    type: "standard",
                    activeKey: ["settings-user"],
                },
                {
                    label: "Usuários",
                    icon: "",
                    link: "settings-user.index",
                    linkType: "route",
                    type: "standard",
                    activeKey: ["settings-user"],
                },
                {
                    label: "Regras",
                    icon: "",
                    link: "settings-role",
                    linkType: "route",
                    type: "standard",
                    activeKey: ["settings-role"],
                },
                {
                    label: "Permissões",
                    icon: "",
                    link: "settings-permission",
                    linkType: "route",
                    type: "standard",
                    activeKey: ["settings-permission"],
                },
                {
                    label: "Sistema",
                    icon: "",
                    link: "settings-system",
                    linkType: "route",
                    type: "standard",
                    activeKey: ["settings-system"],
                }
            ]
        }
    }
}